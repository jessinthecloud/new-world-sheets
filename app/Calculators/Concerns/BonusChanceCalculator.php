<?php

namespace App\Calculators\Concerns;

interface BonusChanceCalculator extends CraftingCalculator
{
    public function totalXp(); // ?
    public function bonusChance(); // ?
}