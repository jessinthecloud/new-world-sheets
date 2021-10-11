<?php

namespace App\Imports\DatabaseSheets;

use App\Models\Items\Item;
use App\Models\Recipes\Recipe;
use App\Models\Tradeskill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\RemembersChunkOffset;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Row;

class ItemDataImport implements ToModel, WithUpserts, WithCalculatedFormulas, HasReferencesToOtherSheets
{
    /*public function collection( Collection $collection )
    {
        $one = $collection->pull(1);
        
        $this->row($one);      
    }*/

    public function model( array $row )
    {
        if($row[0] === 'No.'){
            return null;
        }
        return $this->row( $row);        
    }
    
    public function row( $row )
    {
        
        /*$index = $row->getIndex();
        if($index === 1){
            // skip heading row
            return null;
        }
        $row      = $row->toArray();*/

    // TRADESKILL INFO        
        $original_tradeskill_name = $row[1]; // PROCESS 
        
    // IMAGE INFO
        $crafted_item_name = $row[5];
        $crafted_item_tier = $row[3];
        $required_skill_level = $row[4];
        $description = $row[14];

    // RECIPE INFO
        $raw_materials = $row[6]; // PROCESS
        $refined_materials = $row[7]; // PROCESS
        $total_refined = $row[8];
        $total_raw = $row[9];
        $exp = $row[10];
        $exp_per_refined = $row[11];
        $exp_per_raw = $row[12];

    // PROCESS
        // sometimes has parentheses and sub category
        $tradeskill_name = Str::before($original_tradeskill_name, '(');
        
        /**
         * some item names repeat
         * some are unique per craft skill
         * some are unique based on tier
         */
        $item_slug = $this->determineItemSlug($crafted_item_name, $tradeskill_name, $crafted_item_tier);
        
        // weapons and armor are jpgs
        $image_name = ($tradeskill_name === 'Armoring' || $tradeskill_name === 'Weaponsmithing') ? $item_slug.'.jpg' : $item_slug.'.png';
        
        // convert to array
        $raw_materials = explode(', ', $raw_materials);
        $raw_materials = collect($raw_materials)->map(function($material, $key){
            return [
                // first word is the amount
                'amount' => Str::before($material, ' '),
                'name' => Str::after($material, ' ')
            ];
        })->all();
//  ddd($raw_materials);  

        // convert to array
        $refined_materials = explode(', ', $refined_materials);
        $refined_materials = collect($refined_materials)->map(function($material, $key){
            return [
                // first word is the amount
                'amount' => Str::before($material, ' '),
                'name' => Str::after($material, ' ')
            ];
        })->all();
//  ddd($refined_materials);
    
    // UPSERTS
    
        // tradeskill
        // create related model first
        $tradeskill = Tradeskill::updateOrCreate(
            [
                // unique fields to check
                'name' => $tradeskill_name,
            ], 
            [
                'name' => $tradeskill_name,
                'slug' => Str::slug($tradeskill_name),
                'description' => Str::between($original_tradeskill_name, '(', ')') 
            ]
        );
        
//dump('trade', $tradeskill);        
        // upsert created item
        $crafted_item = Item::updateOrCreate(
            [
                // unique fields
                'slug' => $item_slug,
            ],
            [
                'name' => $crafted_item_name,
                'slug' => $item_slug,
                'description' => $description,
                'tier' => $crafted_item_tier,
                'item_type' => $tradeskill_name,
                // raw, refined, or null
                'item_state' => null,
                'required_skill_level' => $required_skill_level,
                'image' => $image_name,
            ],
        );
        
//  dump('crafted',$crafted_item);
        
        // upsert raw ingredients
        foreach($raw_materials as $i => $raw){
            $raw_slug = $this->determineItemSlug($raw['name'], $tradeskill_name, Str::between($raw['name'], '[', ']'));
            
            $raw_materials[$i]['model']= Item::updateOrCreate(
                [
                    // unique fields
                    'slug' => $raw_slug,
                ],
                [
                    'name' => $raw['name'],
                    'slug' => $raw_slug,
                    'item_type' => $tradeskill_name,
                    // raw, refined, or null
                    'item_state' => 'raw',
                ],
            );
        } // end foreach raw
//dump('raw', $raw_materials);

        // upsert refined ingredients
        foreach($refined_materials as $i => $refined){
            $refined_slug = $this->determineItemSlug($refined['name'], $tradeskill_name, Str::between($refined['name'], '[', ']'));

            $refined_materials[$i]['model']= Item::updateOrCreate(
                [
                    // unique fields
                    'slug' => $refined_slug,
                ],
                [
                    'name' => $refined['name'],
                    'slug' => $refined_slug,
                    'item_type' => $tradeskill_name,
                    // raw, refined, or null
                    'item_state' => 'refined',
                ],
            );
        } // end foreach raw
        
//dump('refined', $refined_materials);

        // get all materials as one
        $materials = collect($raw_materials)->merge($refined_materials);
//dump('all materials', $materials);        
        // upsert recipe
        $recipe = new Recipe(
            [
                'name' => $crafted_item_name.' Recipe',
                'slug' => $item_slug,
                'category' => Str::between($original_tradeskill_name, '(', ')'),
                'tradeskill_id' => $tradeskill->id,
                'item_id' => $crafted_item->id,
            ],
        );

        // attach related models
        $recipe->tradeskill()->associate($tradeskill);
        $recipe->item()->associate($crafted_item);
//dump('recipe',$recipe);
        /*$recipe->save();
        $recipe->refresh();
        $recipe->save();*/

        // attach materials
        $materials->each(function($material, $key) use ($recipe) {
        
//dump('material id: '. $material['model']->id. ', amount: '.$material['amount']);

            // tie recipe to material
            $recipe->ingredients()->attach(
                $material['model']->id,
                // also insert amount into pivot table
                // can't interact with unsaved recipe but
                // can't save recipe before this or all inserts fail
                // because ????????????????
                // so save slug for later mapping
                ['amount' => $material['amount'], 'recipe_slug' => $recipe->slug]
            );
//            $recipe->save();

            /*$material['model']->recipes()->attach(
                $recipe->id,
                // also insert amount into pivot table
                ['amount' => $material['amount']]
            );*/
//            $material['model']->save();
//dump($material['model']);
        });
        
//ddd('final', $recipe);
        return $recipe;
    }

    /**
     * Make sure slug is unique 
     * some item names are unique per craft skill
     * some item names are unique based on tier
     * 
     * TODO: throw exception or otherwise handle when haven't created unique slug
     * 
     * @param string $crafted_item_name
     * @param string $tradeskill_name
     * @param string $crafted_item_tier
     *
     * @return string
     */
    private function determineItemSlug(string $crafted_item_name, string $tradeskill_name, string $crafted_item_tier)
    {
        $slug = Str::slug($crafted_item_name);
        
        if(Item::where('slug', $slug)->count() > 0){
            $trade_slug = $slug . '-' . Str::slug($tradeskill_name);

            if(Item::where('slug', $trade_slug)->count() > 0) {
                return $slug . '-' . Str::slug( $crafted_item_tier);
            }
            return $trade_slug;
        }
        return $slug;
    }

    /**
     * @return string|array
     */
    public function uniqueBy()
    {
        return 'slug';
    }
}
