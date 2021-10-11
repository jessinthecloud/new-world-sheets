<?php

namespace App\Models\Items;

use App\Models\Items\Concerns\HasItemDetails;
use App\Models\Recipes\Recipe;
use Illuminate\Database\Eloquent\Model;

/**
 * Result of a recipe or world drop
 */
class Item extends Model
{
//    use HasItemDetails;

    protected $guarded = [];
//    protected $table = 'items';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function recipe()
    {
        return $this->hasOne(Recipe::class);
    }

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class);
    }
}