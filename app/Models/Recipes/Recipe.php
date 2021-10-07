<?php

namespace App\Models\Recipes;

use Illuminate\Support\Collection;

abstract class Recipe
{
    /** array of Ingredient models */
    protected Collection $ingredients;
    protected Tradeskill $required_skill;
    protected Station $required_station; // including tier/level
    // skill level needed to craft this recipe
    protected int $required_skill_level;
    // xp gained from crafting the recipe
    protected int $experience_points;
}