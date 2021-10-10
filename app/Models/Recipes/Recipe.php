<?php

namespace App\Models\Recipes;

use App\Models\Items\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Recipe extends Model
{
    protected $guarded = [];
    protected $table = 'recipes';
}