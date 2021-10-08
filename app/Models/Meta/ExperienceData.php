<?php

namespace App\Models\Meta;

use App\Models\Tradeskill;

class ExperienceData extends \Illuminate\Database\Eloquent\Model
{
    protected $guarded = [];

    public function tradeskill()
    {
        return $this->belongsTo(Tradeskill::class);
    }
}