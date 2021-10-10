<?php

namespace App\Imports;

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
        // TODO: process bonus chance info 
        
        $this->itemImport->collection($collection);
    }

    public function registerEvents() : array
    {
        return $this->itemImport->registerEvents();
    }

    public function mapping() : array
    {
        // bonus item chance sheet item info
        $ranges = [
            'A' =>[
                [3,7],
                [10,19],
                [22,26],
                [29,33],
                [36,40],
                [43,121],
                [124,135],
            ]
        ];
        $this->itemImport->mapRangesToCells($ranges);
        return $this->itemImport->mapping();
    }
}
