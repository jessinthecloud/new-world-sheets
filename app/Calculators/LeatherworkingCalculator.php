<?php

namespace App\Calculators;

use App\Calculators\Concerns\Calculator;
use App\Calculators\CraftingCalculator;

class LeatherworkingCalculator extends CraftingCalculator
{
    // (RefiningSkill/10) + (BaseBonusItemChanceForCraftedItem*100) + ((CraftedItemTier - IngredientItemTier))*100)
}