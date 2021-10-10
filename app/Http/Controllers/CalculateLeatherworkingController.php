<?php

namespace App\Http\Controllers;

use App\Calculators\Concerns\Calculator;
use App\Enums\MaterialState;
use App\Enums\Tannin;
use App\Http\Requests\LeatherCalculateRequest;
use App\Models\Items\Resource;
use App\Models\Recipes\CraftingRecipe;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CalculateLeatherworkingController extends CalculateController
{
    public function form( Request $request )
    {
        $amountLabel = 'Refining Amount';
        $amountName = 'amount';
        $amountValue = '';

        $recipes = CraftingRecipe::where('item_class', 'like', '%leather%')->get()->unique('recipe_name');   
        $craftedItemLabel = 'Item';
        $craftedItemName = 'item';
        $craftedItemValue = $recipes->map(function($item, $key){
            return '<option value="'.$item->id.'">'.$item->recipe_name.' ['.Str::substr(Str::after($item->recipe_id, 'Leather'), 0, 2).']</option>';
        })->implode('\n');

        // $tannins = Tannin::cases();
        $tannins = [
            'None',
            'Tannin [T3]',
            'RestedTannin [T4]',
            'AgedTannin [T5]',
        ];

        $tannin_field = '';
        foreach($tannins as $tannin){
            $tannin_field .= '<option value="'.$tannin.'">'.$this->studlyToWords($tannin).'</option>';
        }
        
        $materialLabel1 = 'Type of Tannin';
        $materialName1 = 'material1';
        $materialValues1 = $tannin_field;

        // $material_states = MaterialState::cases();
        $material_states = [
            'Raw',
            'Refined',
        ];
        $material_states_field = '';
        foreach($material_states as $material_state){
            $material_states_field .= '<option value="'.$material_state.'">'.$this->studlyToWords($material_state).'</option>';
        }

        $materialLabel2 = 'Material Type';
        $materialName2 = 'material2';
        $materialValues2 = $material_states_field;

        $skillLevelLabel = 'Current Skill Level';
        $skillLevelName = 'skill_level';
    
        return view('calculate-form', [
            'title' => 'Leatherworking Calculator',
            'action' => route('leather-calc-process'),
            'amountLabel' => $amountLabel,
            'amountName' => $amountName,
            'amountValue' => $amountValue,
            'craftedItemLabel' => $craftedItemLabel,
            'craftedItemName' => $craftedItemName,
            'craftedItemValue' => $craftedItemValue,
            'materialLabel1' => $materialLabel1,
            'materialName1' => $materialName1,
            'materialValues1' => $materialValues1,
            'materialLabel2' => $materialLabel2,
            'materialName2' => $materialName2,
            'materialValues2' => $materialValues2,
            'skillLevelLabel' => $skillLevelLabel,
            'skillLevelName' => $skillLevelName,
        ]);
    }

    public function studlyToWords( string $string )
    {
        return implode(' ', preg_split('/(?<=[a-z])(?=[A-Z])|(?=[A-Z][a-z])/', $string, -1, PREG_SPLIT_NO_EMPTY));
    }

    public function calculate( LeatherCalculateRequest | Request $request )
    {
        // Retrieve the validated input data...
        $validated = $request->validated();
        
        $results = $this->calculator->calculate($validated);
    
        return view('calculate-form', [
            'title' => 'Leatherworking Calculator',
            'acton' => route('leather-calc-process'),
            
        ]);
    }
}