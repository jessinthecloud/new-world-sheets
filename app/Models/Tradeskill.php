<?php

namespace App\Models;

use App\Models\Meta\ExperienceData;
use App\Models\Recipes\Recipe;

class Tradeskill extends \Illuminate\Database\Eloquent\Model
{
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function experienceData()
    {
        return $this->hasOne(ExperienceData::class);
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}