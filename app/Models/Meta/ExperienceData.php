<?php

namespace App\Models\Meta;

use App\Models\Tradeskill;

class ExperienceData extends \Illuminate\Database\Eloquent\Model
{
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tradeskill()
    {
        return $this->belongsTo(Tradeskill::class);
    }
}