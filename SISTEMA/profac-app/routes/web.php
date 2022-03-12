<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Bodega; 
use App\Http\Livewire\BodegaComponent\BodegaEditar;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/bodega', Bodega::class);
Route::get('/bodega/editar/screen', BodegaEditar::class);

Route::post('/bodega/crear',  [Bodega::class, 'crearBodega']); 
