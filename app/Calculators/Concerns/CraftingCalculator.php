<?php

namespace App\Calculators\Concerns;

interface CraftingCalculator extends Calculator
{
    public function itemsCrafted();
}