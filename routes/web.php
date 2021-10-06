<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/get-data', [App\Http\Controllers\HttpController::class, 'getAll']);
Route::get('/get-data/{category}', [App\Http\Controllers\HttpController::class, 'getCategory']);
Route::get('/get-data/{category}/{type}', [App\Http\Controllers\HttpController::class, 'getCategoryType']);

Route::get('/scrape', function () {

    $base_url = "https://nwdb.info/db/";
    
    /* 
    /_app/pages/db/[entryType]/[itemId].svelte-b28fafcb.js
    
    <script type="module">
    import { start } from "/_app/start-a5b768b0.js";
    start({
    target: document.querySelector("#svelte"),
    paths: {"base":"","assets":""},
    session: {},
    host: "nwdb.info",
    route: true,
    spa: false,
    trailing_slash: "never",
    hydrate: {
     status: 200,
    error: null,
    nodes: [
        import("/_app/pages/__layout.svelte-77a3b737.js"),
        import("/_app/pages/db/[entryType]/[itemId].svelte-b28fafcb.js")
    ],
    page: {
        host: "nwdb.info",
        path: "/db/item/2hfishingpole_ancient",
        query: new URLSearchParams(""),
        params: {"entryType":"item","itemId":"2hfishingpole_ancient"}
     }
    }
    });
    </script> 
    */
     
    $url = $base_url.'shops/syndicate-armory/page/1';
    $filename = 'shops-syndicate-armory-page-1.html';

    dump('URL: ' . $url);
//        continue;

    $response = Http::accept( 'application/json' )->get( $url );

    dump( $response, $response->body() );


    if ( $response->successful() ) {
        Storage::disk( 'local' )->put(
            storage_path( 'app/json' ) . '/' . $filename,
            $response->body()
        );
        dump(storage_path( 'app/json' ) . '/' .$filename);
    } else {
        dump( 'Request failed: ', $response->status(), $response->headers(), $response->body() );
    }
});

Route::get('/scrape/category/{category}/{type?}', function (string $category, string $type=null) {
    
    $base_url = "https://newworldfans.com/db/category/";

    $url = isset($type) ? $base_url.$category.'/'.$type : $base_url.$category;
    $filename = (isset($type) ? strtolower( $category ).'-'.strtolower($type) : strtolower( $category )).'.json';

    dump('URL: ' . $url);
//        continue;

    $response = Http::accept( 'application/json' )->get( $url.'?page=2' );

    dump( $response, $response->body() );
    

    if ( $response->successful() ) {
        Storage::disk( 'local' )->put(
            storage_path( 'app/json' ) . '/' . $filename,
            $response->body()
        );
        dump(storage_path( 'app/json' ) . '/' .$filename);
    } else {
        dump( 'Request failed: ', $response->status(), $response->headers(), $response->body() );
    }
});

Route::get('/scrape/categories', function () {
    
    $base_url = "https://newworldfans.com/db/category/";
    
    $categories = 
    [
        'Items' => [
            'Ammo',
            'Armor',
            'Consumables',
            'Resources',
            'Weapons',
        ],
        'Recipes' => [
            'Camp',
            'Arcana',
            'Armoring',
            'Cooking',
            'Engineering',
            'Furnishing',
            'Jewelcrafting',
            'Weaponsmithing',
            'Leatherworking',
            'Smelting',
            'Stonecutting',
            'Weaving',
            'Woodworking',
        ],
        'Furniture' => [
            'Beds',
            'Chairs',
            'Decorations',
            'Lighting',
            'Misc',
            'Pets',
            'Shelves',
            'Storage',
            'Tables',
            'Trophies',
            'Vegetation',
        ],
        'Gems' => [
            'Armor',
            'Weapons',
            'Jewelry',
        ],
        'Perks' => [],
        'Achievements' => [],
        'Creatures' => [],
        'Dye' => [],
        'Gatherables' => [],
        'LootContainers' => [],
        'Lore' => [],
        'Quests' => [],
        'weapon-abilities' => [],
        'NPCs' => [],
    ];
    
    foreach ( $categories as $category => $types ) {
    
        $url = $base_url.$category;
        
        dump('URL: ' . $url);
//        continue;
    
        $response = Http::accept( 'application/json' )->get( $url );

        dump( $response, $response->body() );

        if ( $response->successful() ) {
            Storage::disk( 'local' )->put(
                storage_path( 'app/json' ) . '/' . strtolower( $category ) . '.json',
                $response->body()
            );
        } else {
            dump( 'Request failed: ', $response->status(), $response->headers(), $response->body() );
        }
        // don't spam requests
        sleep(3);
    } // end foreach
    
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
