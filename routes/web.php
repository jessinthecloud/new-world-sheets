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

Route::get('/calculate/leatherworking', [App\Http\Controllers\CalculateLeatherworkingController::class, 'form'])->name('leather-calc-form');

Route::post('/calculate/leatherworking', [App\Http\Controllers\CalculateLeatherworkingController::class, 'calculate'])->name('leather-calc-process');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
