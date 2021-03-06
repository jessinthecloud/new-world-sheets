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

Route::get('/import', [App\Http\Controllers\ImportController::class, 'index'])->name('import.index');
// listings
Route::get('/get-nwf-data', [App\Http\Controllers\NwfController::class, 'getAll']);
Route::get('/get-nwf-data/{category}', [App\Http\Controllers\NwfController::class, 'category']);
Route::get('/get-nwf-data/{category}/{type}', [App\Http\Controllers\NwfController::class, 'categoryType']);

// details 
Route::get('/get-nwf-data/item/{slug}', [App\Http\Controllers\NwfController::class, 'item']);
Route::get('/get-nwf-data/recipe/{slug}', [App\Http\Controllers\NwfController::class, 'recipe']);

// decode from json
Route::get('/convert/items', [App\Http\Controllers\ConvertItemsController::class, 'items']);
Route::get('/convert/recipes', [App\Http\Controllers\ConvertRecipesController::class, 'recipes']);

Route::get('/calculate/leatherworking', [App\Http\Controllers\CalculateLeatherworkingController::class, 'form'])->name('leather-calc-form');

Route::post('/calculate/leatherworking', [App\Http\Controllers\CalculateLeatherworkingController::class, 'calculate'])->name('leather-calc-process');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
