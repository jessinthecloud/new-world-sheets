<?php

namespace App\Models\Items\Concerns;

use App\Enums\Rarity;
use App\Enums\Source;
use App\Enums\Tier;

trait HasItemDetails
{
    /** array of Perk models */
    protected array $perks;
    // enum / db static
    protected ItemCategory $category;
    // enum / db static ?
    protected ItemType $type;
    
    /**
     * enums
     */
    // source of item, i.e., crafted
    protected Source $source;
    protected Rarity $rarity;
    protected Tier $tier;

    /**
     * Important primitives
     */
    // permanently tie to character
    protected bool $bind_on_pickup;
    // player level needed to use item
    protected int $required_level;
    protected int $gear_score;
    /**
     * primitives
     */
    protected int $weight;
    protected int $durability;
    protected bool $salvageable;
    protected bool $mission_item;
    protected bool $repairable;
    protected bool $traded;
}