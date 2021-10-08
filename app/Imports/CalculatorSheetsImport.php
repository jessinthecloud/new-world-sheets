<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithUpserts;

class CalculatorSheetsImport implements WithMultipleSheets
{
    use WithConditionalSheets;

    public function conditionalSheets(): array
    {
        return [
            'EXP Data' => new ExperienceDataImport(),
            
            'Bonus Item Chance Data' => new BonusItemChanceImport(new ItemInfoImport()),
            'Bonus Item Validation' => new BonusItemValidationImport(),
            
            'Leatherworking Calculator' => new ItemInfoImport(),
            'Smelting Calculator' => new ItemInfoImport(),
            'Stonecutting Calculator' => new ItemInfoImport(),
            'Weaving Calculator' => new ItemInfoImport(),
            'Woodworking Calculator' => new ItemInfoImport(),
            'Arcana Calculator' => new ArcanaImport(),
        ];
    }
}
