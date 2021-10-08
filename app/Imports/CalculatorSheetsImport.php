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
            'Leatherworking Calculator' => new LeatherworkingImport(),
            'Smelting Calculator' => new SmeltingImport(),
            'Stonecutting Calculator' => new StonecuttingImport(),
            'Weaving Calculator' => new WeavingImport(),
            'Woodworking Calculator' => new WoodworkingImport(),
            'Arcana Calculator' => new ArcanaImport(),
            'Bonus Item Validation' => new BonusItemValidationImport(),
            'Bonus Item Chance Data' => new BonusItemChanceImport(),
            'EXP Data' => new ExperienceDataImport(),
        ];
    }
}
