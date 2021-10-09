<?php

namespace App\Models\Recipes;

use App\Models\Items\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class Recipe extends Model
{
    protected $guarded = [];
    protected $table = 'recipes';

    /** array of Ingredient models */
    protected Collection $ingredients;
    // skill and level needed to craft this recipe
    protected Tradeskill $required_skill; // including level
    protected CraftingStation $required_station; // including tier/level
    // xp gained from crafting the recipe
    protected int $experience_points;
    protected int $territory_standing;
    protected Item $result;
    
}