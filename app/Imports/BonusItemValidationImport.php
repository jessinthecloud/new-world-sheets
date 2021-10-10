<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use Maatwebsite\Excel\Row;

class BonusItemValidationImport implements ToCollection, OnEachRow, WithEvents, SkipsEmptyRows
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

    public function onRow( Row $row )
    {
//        $rowIndex = $row->getIndex();
//        $row      = $row->toArray();
//    ddd('ROW INDEX', $rowIndex, 'ROW', $row);
        // bonus item chance sheet item info
        $ranges = [
            'C' =>[
                [23,35],
                [61,92],
                [114,125],
                [148,160],
                [184,197],
                [209,342],
            ],
            'D' =>[
                [23,35],
                [61,92],
                [114,125],
                [148,160],
                [184,197],
                [209,342],
            ],
            'E' =>[
                [23,35],
                [61,92],
                [114,125],
                [148,160],
                [184,197],
                [209,342],
            
            ]
        ];
        $map = [
            'C' => 'items',
            'D' => 'images',
            'E' => 'weight',
        ];
        
        $rowVals = [
            'leatherworking'=> [
                'ingredients' => [
                    'refined' => [
                        'range' => ['C5','L9'],
                        'heading_row' => 4, // row #
                        'ingredient' => 2, // col # (row array index)
                        'quantity' => 3, // col # (row array index)
                    ],
                    'raw' => [
                        'range' => ['C12','L20'],
                        'heading_row' => 12, // row #
                        'ingredient' => 2, // col # (row array index)
                        'quantity' => 3, // col # (row array index)
                    ],
                ],
                'items' => [
                    'range' => ['C23','E35'],
                    'heading_row' => 22, // row #
                    'item' => 2, // col # (row array index)
                    'image' => 3, // col # (row array index)
                    'weight' => 4, // col # (row array index)
                ],
                'experience' => [
                    'row' => 23,
                    'col' => 7 // col # (row array index)
                ]
            ], // end leatherworking
        ];

        if($row->getIndex() < $rowVals['leatherworking']['items']['heading_row']+1) {
            return null;
        }
        
//        $this->itemImport->mapRangesToRows($ranges, $map);
        $this->itemImport->processRow($row, $rowVals);
        
        return $this->itemImport->onRow($row);
    }
}
