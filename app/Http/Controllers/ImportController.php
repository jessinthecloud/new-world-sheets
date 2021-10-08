<?php

namespace App\Http\Controllers;

use App\Imports\CalculatorSheetsImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function index()
    {
        $import = new CalculatorSheetsImport();
        $import->onlySheets('EXP Data');
        Excel::import($import, 'calculators.xlsx');

        return redirect('/')->with('success', 'All good!');
    }
}