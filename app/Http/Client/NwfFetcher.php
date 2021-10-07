<?php

namespace App\Http\Client;

class NwfFetcher extends DataFetcher
{
    protected array $categories = [
        // $category => [
        //    $type => total $page #
        // ]

        // despite having subsection, Items isn't in URL
        /*'Items' => [
                'Ammo' => 1,
                'Armor' => 74,
                'Consumables' => 7,
                'Resources' => 94,
                'Weapons' => 52,
            ],*/
        'Ammo' => 1,
        'Armor' => 74,
        'Consumable' => 7,
        'Resource' => 94,
        'Weapon' => 52,
        'Recipes' => [
            'Camp' => 1,
            'Arcana' => 4,
            'Armoring' => 19,
            'Cooking' => 5,
            'Engineering' => 3,
            'Furnishing' => 5,
            'Jewelcrafting' => 4,
            'Weaponsmithing' => 3,
            'Leatherworking' => 1,
            'Smelting' => 1,
            'Stonecutting' => 3,
            'Weaving' => 1,
            'Woodworking' => 1,
        ],
        'Furniture' => [
            'Beds' => 1,
            'Chairs' => 1,
            'Decorations' => 3,
            'Lighting' => 1,
            'Misc' => 2,
            'Pets' => 1,
            'Shelves' => 2,
            'Storage' => 1,
            'Tables' => 1,
            'Trophies' => 1,
            'Vegetation' => 1,
        ],
        'Gems' => [
            'Armor' => 1,
            'Weapons' => 2,
            'Jewelry' => 1,
        ],
        'Perks'=> [
            'Armor' => 3,
            'Weapons' => 3,
            'Jewelry' => 3,
            'Amulet' => 2,
            'Earring' => 2,
            'Bag' => 1,
            'Ring' => 2,
            'Tool' => 1,
            'Fishing Pole' => 1,
            'Sword' => 2,
            'Shield' => 1,
            'Hatchet' => 2,
            'Rapier' => 2,
            'Greataxe' => 2,
            'Warhammer' => 2,
            'Spear' => 7,
            'Bow' => 2,
            'Musket' => 2,
            'Fire Staff' => 2,
            'Life Staff' => 2,
            'Ice Magic' => 2,
        ],
        'Achievements'=> 14,
        'Creatures'=> 86,
        'Dye'=> 2,
        'Gatherables'=> 8,
        'LootContainers'=> 2,
        'Lore'=> 1,
        'Quests'=> 28,
        'weapon-abilities'=> 1,
        'NPCs'=> 5,
    ];

    protected $start_page = 1;

    public function __construct()
    {
        parent::__construct('https://newworldfans.com/db/');
    }

    public function getAll(?int $start_page=null)
    {
        // loop categories
        foreach($this->categories as $category => $types_array){
            $this->getCategory($category, $start_page);
        }
    }

    public function getCategory(string $category, ?int $start_page=null)
    {
        if( !is_array($this->categories[$category]) ) {
            // loop pages
            return $this->loopEntityPages( $category, null, $this->categories[$category], $start_page );
        }

        // loop types
        foreach($this->categories[$category] as $type => $end_page){
            $this->getCategoryType($category, $type, $start_page, $end_page);
        }
    }

    public function getCategoryType(string $category, string $type, ?int $start_page=null, ?int $end_page=null)
    {
        // loop pages
        $end_page = $end_page ?? $this->categories[$category][$type];
        $this->loopEntityPages($category, $type, $end_page, $start_page);
    }

    protected function loopEntityPages(string $category, ?string $type, int $end, ?int $start=null)
    {
        $url_piece = $category . (isset($type) ? '/'.$type : '');
        $i = $start ?? $this->start_page;
        while($i <= $end){
            $this->fetch($url_piece, $i, 1);
            $i++;
        }
    }
}