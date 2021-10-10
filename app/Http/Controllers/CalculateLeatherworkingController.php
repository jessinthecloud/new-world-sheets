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

    protected string $amountValue;
    protected string $amountName;
    protected string $amountLabel;
    protected string $craftedItemLabel;
    protected string $craftedItemName;
    protected string $craftedItemValue;
    protected string $materialLabel1;
    protected string $materialName1;
    protected string $materialValues1;
    protected string $materialLabel2;
    protected string $materialName2;
    protected string $materialValues2;
    protected string $skillLevelLabel;
    protected string $skillLevelName;
    protected string $skillLevelValue;

    public function __construct( Calculator $calculator )
    {
        parent::__construct( $calculator );
    }
    
    protected function buildFormData()
    {
        $this->amountLabel = 'Refining Amount';
        $this->amountName = 'amount';
        $this->amountValue = old($this->amountName) ?? '';

        $recipes = CraftingRecipe::where('item_class', 'like', '%leather%')->get()->unique('recipe_name');
        $this->craftedItemLabel = 'Item';
        $this->craftedItemName = 'item';
        $this->craftedItemValue = $recipes->map(function($item, $key){
            $option = '<option value="'.$item->id.'"';
            if(old($this->craftedItemName) === $item->id){
                $option .= ' SELECTED ';
            }
            $option .= '>'
                . $item->recipe_name
                . ' ['.Str::substr(Str::after($item->recipe_id, 'Leather'), 0, 2).']
            </option>';

            return $option;
        })->implode('\n');

        // $tannins = Tannin::cases();
        $tannins = [
            'None',
            'Tannin [T3]',
            'RestedTannin [T4]',
            'AgedTannin [T5]',
        ];

        $this->materialLabel1 = 'Type of Tannin';
        $this->materialName1 = 'material1';
        $tannin_field = '';
        foreach($tannins as $tannin){
            $tannin_field .= '<option value="'.$tannin.'"';
            if(old($this->materialName1) === $tannin){
                $tannin_field .= ' SELECTED ';
            }
            $tannin_field .= '>'.$this->studlyToWords($tannin).'</option>';
        } // end foreach
        $this->materialValues1 = $tannin_field;

        // $material_states = MaterialState::cases();
        $material_states = [
            'Raw',
            'Refined',
        ];
        $material_states_field = '';
        $this->materialLabel2 = 'Material Type';
        $this->materialName2 = 'material2';
        foreach($material_states as $material_state){
            $material_states_field .= '<option value="'.$material_state.'"';
            if(old($this->materialName2) === $material_state){
                $material_states_field .= ' SELECTED ';
            }
            $material_states_field .= '>'.$this->studlyToWords($material_state).'</option>';
        }
        $this->materialValues2 = $material_states_field;

        $this->skillLevelLabel = 'Current Skill Level';
        $this->skillLevelName = 'skill_level';
        $this->skillLevelValue = old($this->skillLevelName) ?? '';
    }

    public function form( Request $request )
    {
        $this->buildFormData();
    
        return view('calculate-form', [
            'title' => 'Leatherworking Calculator',
            'action' => route('leather-calc-process'),
            'amountLabel' => $this->amountLabel,
            'amountName' => $this->amountName,
            'amountValue' => $this->amountValue,
            'craftedItemLabel' => $this->craftedItemLabel,
            'craftedItemName' => $this->craftedItemName,
            'craftedItemValue' => $this->craftedItemValue,
            'materialLabel1' => $this->materialLabel1,
            'materialName1' => $this->materialName1,
            'materialValues1' => $this->materialValues1,
            'materialLabel2' => $this->materialLabel2,
            'materialName2' => $this->materialName2,
            'materialValues2' => $this->materialValues2,
            'skillLevelLabel' => $this->skillLevelLabel,
            'skillLevelName' => $this->skillLevelName,
            'skillLevelValue' => $this->skillLevelValue,
        ]);
    }

    public function studlyToWords( string $string )
    {
        return implode(' ', preg_split('/(?<=[a-z])(?=[A-Z])|(?=[A-Z][a-z])/', $string, -1, PREG_SPLIT_NO_EMPTY));
    }

    public function calculate( LeatherCalculateRequest $request )
    {
        // Retrieve the validated input data...
        $validated = $request->validated();
  dump($validated);      
        $results = $this->calculator->calculate($validated);

        $this->buildFormData();

        return view('calculate-form', [
            'title' => 'Leatherworking Calculator',
            'action' => route('leather-calc-process'),
            'amountLabel' => $this->amountLabel,
            'amountName' => $this->amountName,
            'amountValue' => $validated['amount'] ?? $this->amountValue,
            'craftedItemLabel' => $this->craftedItemLabel,
            'craftedItemName' => $this->craftedItemName,
            'craftedItemValue' => $this->craftedItemValue,
            'materialLabel1' => $this->materialLabel1,
            'materialName1' => $this->materialName1,
            'materialValues1' => $this->materialValues1,
            'materialLabel2' => $this->materialLabel2,
            'materialName2' => $this->materialName2,
            'materialValues2' => $this->materialValues2,
            'skillLevelLabel' => $this->skillLevelLabel,
            'skillLevelName' => $this->skillLevelName,
            'skillLevelValue' => $validated['skill_level'] ?? $this->skillLevelValue,
        ]);
    }
}