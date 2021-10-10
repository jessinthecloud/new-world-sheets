<?php

namespace App\Http\Controllers;

use App\Imports\CalculatorSheetsImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function index()
    {
        $import = new CalculatorSheetsImport();

        $import->onlySheets(
//            'EXP Data',
//            'Bonus Item Chance Data',
            'Bonus Item Validation',
//            'Leatherworking Calculator',
//            'Smelting Calculator',
//            'Stonecutting Calculator',
//            'Weaving Calculator',
//            'Woodworking Calculator',
//            'Arcana Calculator'
        );
        
        Excel::import($import, 'calculators.xlsx');
dump('done');
//        return redirect('/')->with('success', 'All good!');
    }
}