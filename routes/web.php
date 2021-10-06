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

Route::get('/get-nwf-data', [App\Http\Controllers\NwfController::class, 'getAll']);
Route::get('/get-nwf-data/{category}', [App\Http\Controllers\NwfController::class, 'category']);
Route::get('/get-nwf-data/{category}/{type}', [App\Http\Controllers\NwfController::class, 'categoryType']);

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
