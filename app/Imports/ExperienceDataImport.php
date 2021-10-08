<?php

namespace App\Imports;

use App\Models\Meta\ExperienceData;
use App\Models\Tradeskill;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class ExperienceDataImport implements ToModel, WithCalculatedFormulas, HasReferencesToOtherSheets
{
    /**
     * @param array $row
     *
     * @return \App\Models\Meta\ExperienceData()|null
     */
    public function model(array $row)
    {
        if($row[0] === 'Trade Skill' || $row[0] === null){
            // skip first row
            return null;
        }
        
        // create related model first
        $tradeskill = Tradeskill::updateOrCreate([
            'name' => $row[0],
        ]);
        
        $expData = new ExperienceData([
            'skill_level' => $row[1],
            'xp_to_next_level' => $row[2],
            'xp_at_current_level' => $row[3],
            'total_xp' => $row[4],
            'character_xp' => $row[5],
            'efficiency' => $row[6],
            'bonus_roll' => $row[7],
        ]);
        
        // attach related model
        $expData->tradeskill()->associate($tradeskill);
//ddd($expData);
        // save is done by the Import
        
        return $expData;
    }
}
