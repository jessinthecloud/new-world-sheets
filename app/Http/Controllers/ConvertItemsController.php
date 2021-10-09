<?php

namespace App\Http\Controllers;

use App\Converters\Concerns\Converter;
use App\Converters\ItemConverter;
use App\Models\Items\Ammo;
use App\Models\Items\Armor;
use App\Models\Items\Consumable;
use App\Models\Items\Resource;
use App\Models\Items\Weapon;
use Illuminate\Filesystem\Filesystem;


class ConvertItemsController extends \Illuminate\Routing\Controller
{
    /**
     * @var \App\Converters\Concerns\Converter
     */
    protected Converter $converter;

    public function __construct(Converter $converter)
    {
        $this->converter = $converter;
    }

    public function items(Filesystem $filesystem)
    {
        $item_types = [
            'ammo',
            'armor',
            'consumable',
            'resource',
            'weapon',
        ];
        
        foreach($item_types as $item_type){

dump('path: '.storage_path('app/json/'.$item_type.'/'));
            
            $this->converter->fromPath($filesystem, storage_path('app/json/'.$item_type.'/'), 'App\Models\Items\\', 'item_type' );
        }
    }
}