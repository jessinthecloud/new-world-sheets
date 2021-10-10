<?php

namespace App\Calculators;

use App\Calculators\Concerns\BonusChanceCalculator;
use App\Models\Items\Concerns\Craftable;

abstract class CraftingCalculator implements Concerns\CraftingCalculator, BonusChanceCalculator
{
    protected int $amount_made;
    protected Craftable $item;
    
    public function calculate($data)
    {
        // TODO: Implement calculate() method.
    }

    public function itemsCrafted()
    {
        // TODO: Implement itemsCrafted() method.
        
        $this->bonusChance();
    }

    public function bonusChance(  )
    {
        // TODO: Implement bonusChance() method.
    }

    public function totalXp()
    {
        // TODO: Implement totalXp() method.
    }
}
