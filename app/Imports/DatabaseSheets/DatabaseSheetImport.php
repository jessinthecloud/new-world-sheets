<?php

namespace App\Imports\DatabaseSheets;

use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DatabaseSheetImport implements WithMultipleSheets
{
    use WithConditionalSheets;

    public function conditionalSheets(): array
    {
        return [
            'Item Data' => new ItemDataImport(),
        ];
    }
}
