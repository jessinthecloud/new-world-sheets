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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
