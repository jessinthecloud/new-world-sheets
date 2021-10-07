<?php

namespace App\Models\Items;

use App\Models\Items\Concerns\HasItemDetails;
use Illuminate\Database\Eloquent\Model;

/**
 * Result of a recipe or world drop
 */
abstract class Item extends Model
{
    use HasItemDetails;

}