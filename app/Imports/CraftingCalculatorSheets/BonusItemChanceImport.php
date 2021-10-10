<?php

namespace App\Imports\CraftingCalculatorSheets;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMappedCells;

class BonusItemChanceImport  implements ToCollection, WithMappedCells, WithEvents, SkipsEmptyRows
{
    protected ItemInfoImport $itemImport;
    
    public function __construct(ItemInfoImport $import=null)
    {
        $this->itemImport = $import;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $this->itemImport->collection($collection);
    }

    public function registerEvents() : array
    {
        return $this->itemImport->registerEvents();
    }

    public function mapping() : array
    {
        return $this->itemImport->mapping();
    }
}
