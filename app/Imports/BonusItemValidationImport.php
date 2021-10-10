<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithEvents;

class BonusItemValidationImport implements ToCollection, WithEvents, SkipsEmptyRows
{
    /**
     * @param Collection $rows
     *
     * @throws \Exception
     */
    public function collection(Collection $rows)
    {
        $craft_skills_map = [
            // Leatherworking
            [
                'title' => [0,1],
                'rows' => [2,34], // rows with data INDEX FROM 0
                'refined' => [
                    'rows' => [2,8],
                    // rows with data only - no headings
                    'num_data_rows' => 5,
                ],
                'raw' => [
                    'rows' => [10,19],
                    // rows with data only - no headings
                    'num_data_rows' => 8,
                ],
                'items_data' => [
                    'rows' => [21,34],
                    // rows with data only - no headings
                    'num_data_rows' => 13,
                    // specific values
                    'indexes' =>[
                        'item_name' => 2, // row index
                        'image' => 3, // row index
                        'weight' => 4, // row index
                        'crafted_item_name' => 6, // row index
                        'crafted_xp' => 7, // row index
                    ],
                ],
            ],
            // Smelting
            [
                'title' => [36,1], 
                'rows' => [37,91], // rows with data
            ],
            // Stonecutting
            [
                'title' => [93,1], 
                'rows' => [94,124], // rows with data
            ],
            // Weaving
            [
                'title' => [126,1], 
                'rows' => [127,159], // rows with data
            ],
            // Woodworking
            [
                'title' => [161,1], 
                'rows' => [162,196], // rows with data
            ],
            // Arcana
            [
                'title' => [198,1],
                'rows' => [199,341], // rows with data
            ],
        ];
        
//        $craft_skill = $rows->pull(0)->pull(1);

/*
        'title' => [0,1],
        // INDEX FROM 0
        'rows' => [2,34], // rows with data 
        'refined_data_rows' => [2,8],
        'raw_data_rows' => [10,19],
        'all_items_rows' => [21,34],
        'items' => 2, // row index
        'images' => 3, // row index
        'weight' => 4, // row index 
*/

        $craft_skill = [];
        foreach($craft_skills_map as $craft_skill_map){
       
            $title = $rows->get($craft_skill_map['title'][0])->get($craft_skill_map['title'][1]);
            
            // make data set smaller and easier to work with
            // while maintaining the original data for later
            $section_data_rows = $rows->slice(
                // sheet's data begins here
                $craft_skill_map['rows'][0],
                // number of rows related to this data in the spreadsheet
                ($craft_skill_map['rows'][1] - $craft_skill_map['rows'][0])
            )
            // remove empty rows so that we can
            // work with data only and remove as we go
            ->filter()
            ->values()
            ;
//            dump($section_data_rows->all());
dump($title);
        /* REFINED MATERIALS DATA */
            // section's heading labels
            $refined_heading = $section_data_rows->pull(0);
            // reset keys
            $section_data_rows = $section_data_rows->values();
            // number of rows for this section, to avoid using specific indexes
            $num_ref_data_rows = ($craft_skill_map['refined_data_rows'][1] - $craft_skill_map['refined_data_rows'][0]) - 1;
dump('refined heading', $refined_heading, $num_ref_data_rows.' rows');
            // data for this section
            $refined_data = $section_data_rows->splice(0, $num_ref_data_rows);
dump('refined data', $refined_data);
        /* RAW MATERIALS DATA */
            // first 2 rows are the heading label rows for section from spreadsheet
            // get rid of the first 
            $section_data_rows->pull(0);
            // save good heading
            $raw_heading = $section_data_rows->pull(1);
            // reset keys
            $section_data_rows = $section_data_rows->values();
            // number of rows for this section, to avoid using specific indexes
            $num_ref_data_rows = ($craft_skill_map['raw_data_rows'][1] - $craft_skill_map['raw_data_rows'][0]) - 1;
dump('raw heading',$raw_heading);
            // data for this section
            $raw_data = $section_data_rows->splice(0, $num_ref_data_rows);
dump('raw data', $raw_data);

        /* ITEMS DATA */
            // first row is the heading label row for section from spreadsheet
            $items_heading = $section_data_rows->pull(0);
            // number of rows for this section, to avoid using specific indexes
            // dont subtract 1 because only 1 header row
            $num_items_data_rows = ($craft_skill_map['items_data_rows'][1] - $craft_skill_map['items_data_rows'][0]);
dump('items heading', $items_heading);
            // data for this section
            $items_data = $section_data_rows->splice(0, $num_items_data_rows);
dump('items data', $items_data);
            

ddd($section_data_rows);
            $craft_skill[$title] = $section_data_rows;
ddd($craft_skill);            
        }
        
        /*$rows = $rows->map(function($row, $key){
            ddd($key, $row);
            $row = $row->map(function($cell, $index){
                
                return $cell;
            });
            return $row;
        });
        ddd('---');*/
    }

    public function registerEvents() : array
    {
        return [];
    }

}
