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


class ConvertRecipesController extends \Illuminate\Routing\Controller
{
    /**
     * @var \App\Converters\Concerns\Converter
     */
    protected Converter $converter;

    public function __construct(Converter $converter)
    {
        $this->converter = $converter;
    }

    public function recipes(Filesystem $filesystem)
    {
        $this->converter->fromPath($filesystem, storage_path('app/json/recipes/'), 'App\Models\Recipes\\', 'type' );
    }
}