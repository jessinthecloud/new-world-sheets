<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMappedCells;

class BonusItemChanceImport implements ToCollection, WithEvents, SkipsEmptyRows
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        ddd($collection);
    }

    public function registerEvents() : array
    {
        return [];
    }

}
