<?php

namespace App\Models\Recipes;

use App\Models\Items\Item;
use App\Models\Tradeskill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Recipe extends Model
{
    protected $guarded = [];
//    protected $table = 'recipes';

    /**
     * Item the recipe can craft 
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
        return $this->belongsTo(Item::class);    
    }

    public function tradeskill()
    {
        return $this->belongsTo(Tradeskill::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Item::class);
    }
}