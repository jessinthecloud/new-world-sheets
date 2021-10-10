<?php

namespace App\Http\Controllers;

use App\Calculators\Concerns\Calculator;
use Illuminate\Http\Request;

abstract class CalculateController extends Controller
{
    /**
     * @var \App\Calculators\Concerns\Calculator
     */
    protected Calculator $calculator;

    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
    }

    abstract public function form(Request $request);
    
    abstract public function calculate(Request $request);
}