<?php

namespace App\Imports;

use App\Models\Items\Resource;
use App\Models\Meta\ExperienceData;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Row;

class ItemInfoImport implements ToCollection, OnEachRow, WithMappedCells, WithEvents, SkipsEmptyRows
{
    protected ?array $cells;
    protected ?array $rows;
    protected array $row = [];

    /**
    * @param Collection $cells
    */
    public function collection(Collection $cells)
    {
        ddd('collection method', $cells);
        
        foreach($cells as $cell){
            if( !isset($cell) ){
                continue;
            }
            // crafted item & material type
            $resource = Resource::updateOrCreate(
                [
                   'name' => Str::before($cell, '['),
                   'tier' => Str::between($cell, '[', ']'),
                ],
                [
                    'name' => Str::before($cell, '['),
                    'tier' => Str::between($cell, '[', ']'),
                ]
            );
        }
    }

    public function mapRangesToCells( array $ranges )
    {
        // create cell coords to import
        foreach($ranges as $col => $column_range){
            foreach($column_range as $cells){
                for($i=$cells[0]; $i<=$cells[1]; $i++){
                    $this->cells []= $col.$i;
                }
            }
        }
    }

    public function mapRangesToRows( array $ranges, array $map )
    {
dump($map,$ranges);
        // create cell coords to import
        foreach($ranges as $col => $column_range){
            foreach($column_range as $cells){
                for($i=$cells[0]; $i<=$cells[1]; $i++){
                    $this->rows [$map[$col]][]= $col.$i;
                }
            } // end cell
        } // end cols
dump($this->rows);
    }

    public function mapping() : array
    {
        return $this->cells ?? $this->rows['items'];
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

    public function processRow($row, $data)
    {
        if($row->getIndex() === $data['leatherworking']['items']['heading_row']+1){
            $row = $row->toArray();
//            ddd($row->toArray(), $data);
//ddd($row, $data['leatherworking']['items']['item'], $data['leatherworking']['items']['weight']);
            $this->row = [
                'item' => $row[$data['leatherworking']['items']['item']],
                'tier' => $row[$data['leatherworking']['items']['item']],
                'weight' => $row[$data['leatherworking']['items']['weight']]
            ];
        }
    }

    public function onRow( Row $row )
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();
if(!empty($this->row)){
    dump($this->row, $row);
}
        return $this->row;
    }
}
