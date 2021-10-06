<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class HttpController
{

    protected $categories =
    [   
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
    
    protected string $site;
    protected string $base_url;
    protected int $start_page;
    protected Request $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->start_page = $this->request->page ?? 1;
        $this->site = $this->request->site ?? 'newworldfans';
        $this->base_url = ($this->site === 'nwdb') ? "https://nwdb.info/db/" : 'https://newworldfans.com/db/';
    }

    public function getAll()
    {
        // loop categories
        foreach($this->categories as $category => $types_array){
            $this->getCategory($category);
        }
    }

    public function getCategory(string $category)
    {
        if( !is_array($this->categories[$category]) ) {
            // loop pages
            return $this->loopEntityPages( $category, null, $this->categories[$category] );
        }

        // loop types
        foreach($this->categories[$category] as $type => $end_page){
            $this->getCategoryType($category, $type, $end_page);
        }
    }

    public function getCategoryType(string $category, string $type, ?int $end_page=null)
    {
        // loop pages
        $end_page = $end_page ?? $this->categories[$category][$type];
        $this->loopEntityPages($category, $type, $end_page);
    }
    
    protected function loopEntityPages(string $category, ?string $type, int $end, int $start=null)
    {
        $i = $start ?? $this->start_page;
        while($i <= $end){
            $this->getData($category, $type, $i);
            $i++;
        }
    }

    protected function getData(string $category, ?string $type, int $page=1, int $sleep=1)
    {
        $this->makeRequest(
            $this->buildUrl($category, $type, $page),
            $this->buildFilename($category, $type, $page)
        );
        // don't spam requests
        sleep($sleep);
    }
    
    protected function buildUrl(string $category, ?string $type, int $page=1) : string
    {
        $url = isset($type) ? $this->base_url.'category/'.$category.'/'.$type : $this->base_url.'category/'.$category;
        $url .= isset($page) ? '?page='.$page : '';
        
dump('URL: ' . $url);
        
        return $url;
    }
    
    protected function buildFilename(string $category, ?string $type, int $page=1) : string
    {
        $path = 'json/'.strtolower($category).'/';
        
        $filename = isset($type) ? strtolower( $category ).'-'.strtolower($type) : strtolower( $category );
        $filename .= isset($page) ? '-'.$page : '';
        $filename = $path.$filename;
dump('Filename: ' . $filename);
        
        return $filename;
    }
    
    protected function makeRequest(string $url, string $filepath)
    {
    
        $response = Http::accept( 'application/json' )->get( $url );

dump( $response, $response->body() );

        if ( $response->successful() ) {
            Storage::disk( 'local' )->put(
                $filepath . '.json',
                $response->body()
            );
        } else {
            dd( 'Request failed: ', $response->status(), $response->headers(), $response->body() );
        }
    }
    
    
}