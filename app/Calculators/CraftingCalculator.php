<?php

namespace App\Calculators;

use App\Models\Items\Concerns\Craftable;

abstract class CraftingCalculator implements Concerns\CraftingCalculator
{
    protected int $amount_made;
    protected Craftable $item;
    
    public function calculate()
    {
        // TODO: Implement calculate() method.
    }

    public function itemsCrafted()
    {
        // TODO: Implement itemsCrafted() method.
    }
}
