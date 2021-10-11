<?php

namespace App\Http\Controllers;

use App\Imports\CraftingCalculatorSheets\CalculatorSheetsImport;
use App\Imports\DatabaseSheets\DatabaseSheetImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function index()
    {
        $import = new CalculatorSheetsImport();

        $import->onlySheets(
            'EXP Data',
//            'Bonus Item Chance Data',
//            'Bonus Item Validation',
//            'Leatherworking Calculator',
//            'Smelting Calculator',
//            'Stonecutting Calculator',
//            'Weaving Calculator',
//            'Woodworking Calculator',
//            'Arcana Calculator'
        );
        
        Excel::import($import, 'calculators.xlsx');

        /*$import = new DatabaseSheetImport();

        $import->onlySheets(
            'Item Data',
//            'Perks Data',
//            'EXP Data',
//            'Calculator',
//            'Perks',
        );

        Excel::import($import, 'database.xlsx');*/
dump('done');
//        return redirect('/')->with('success', 'All good!');
    }
}