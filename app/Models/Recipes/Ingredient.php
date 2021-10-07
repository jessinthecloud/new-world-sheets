<?php

namespace App\Models\Recipes;

use App\Enums\MaterialState;
use App\Enums\Tier;
use App\Models\Items\Resource;
use Illuminate\Database\Eloquent\Model;

/**
 * Requirement for a recipe - combo of material + requirements
 */
class Ingredient extends Model
{
    protected int $amount;
    protected Tier $tier;
    protected Resource $resource;
    protected MaterialState $state;
}