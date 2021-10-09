<?php

namespace App\Http\Controllers;

use App\Converters\ItemConverter;
use App\Models\Items\Ammo;
use App\Models\Items\Armor;
use App\Models\Items\Consumable;
use App\Models\Items\Resource;
use App\Models\Items\Weapon;

class ConvertController extends \Illuminate\Routing\Controller
{
    protected array $items = [
        'ammo',
        'armor',
        'consumable',
        'resource',
        'weapon',
    ];
    
    public function items(ItemConverter $converter)
    {
        // get file
        $converter->loadData(
            storage_path('app/json/armor/'),
            Armor::class
        );

        $converter->loadData(
            storage_path('app/json/ammo/'),
            Ammo::class
        );

        $converter->loadData(
            storage_path('app/json/consumable/'),
            Consumable::class
        );

        $converter->loadData(
            storage_path('app/json/resource/'),
            Resource::class
        );

        $converter->loadData(
            storage_path('app/json/weapon/'),
            Weapon::class
        );
    }
}