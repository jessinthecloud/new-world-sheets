<?php

namespace App\Converters;

use App\Converters\Concerns\Converter;
use App\Http\Client\Fetcher;
use App\Models\Items\Ammo;
use App\Models\Items\Armor;
use App\Models\Items\Consumable;
use App\Models\Items\Resource;
use App\Models\Items\Weapon;
use DirectoryIterator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ItemConverter extends JsonConverter
{
    
}   