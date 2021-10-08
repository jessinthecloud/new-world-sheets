<?php

namespace App\Imports;

use App\Models\Items\Resource;
use App\Models\Meta\ExperienceData;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use Maatwebsite\Excel\Events\AfterSheet;

class ItemInfoImport implements ToCollection, WithMappedCells, WithEvents, SkipsEmptyRows
{
    /**
    * @param Collection $cells
    */
    public function collection(Collection $cells)
    {
//        ddd($cells);
        
        foreach($cells as $cell){
            if( !isset($cell) ){
                continue;
            }
            // crafted item & material type
            Resource::updateOrCreate([
               'name' => Str::before($cell, '['),
               'tier' => Str::between($cell, '[', ']'),
           ]);
        }
    }

    public function mapping() : array
    {
        $col = 'A';
        $ranges = [
            [3,7],
            [10,19],
            [22,26],
            [29,33],
            [36,40],
            [43,121],
            [124,135],
        ];
        $cells = [];
        // create cell coords to import
        foreach($ranges as $range){
            for($i=$range[0]; $i<=$range[1]; $i++){
                $cells []= $col.$i;
            }
        }
//        dump($cells);
        return $cells;
    }

    public function registerEvents() : array
    {
        return [
            // Array callable, refering to a static method.
//            AfterSheet::class => [self::class, 'afterSheet'],
            AfterSheet::class => function(AfterSheet $event) {
//                ddd($this);
            },
        ];
    }

    public static function afterSheet(AfterSheet $event)
    {
        // read the hidden cell data?
        // ddd($event->sheet->getDelegate()->toArray(null, false));
    }
}
