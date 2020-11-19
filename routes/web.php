<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\StockController::class, 'index'])->name('index');

Auth::routes();

Route::get('/logout', function (){
    auth()->logout();
    Session()->flush();

    return \Illuminate\Support\Facades\Redirect::to('/');
})->name('logout');

Route::get('/product/add',[App\Http\Controllers\StockController::class, 'add'] )->name('product.add')->middleware('Auth');
Route::get('/product/remove', [App\Http\Controllers\StockController::class, 'remove'])->name('product.remove')->middleware('Auth');
Route::post('/remove/product/', [App\Http\Controllers\StockController::class, 'destroy'] )->name('product.destroy')->middleware('Auth');
Route::post('/add/product/post',[App\Http\Controllers\StockController::class, 'store'] )->name('product.add.post')->middleware('Auth');


Route::get('/add/item/{id}', [App\Http\Controllers\StockController::class, 'additem'])->name('add.item')->middleware('Auth');
Route::get('/remove/item/{id}', [App\Http\Controllers\StockController::class, 'removeitem'])->name('remove.item')->middleware('Auth');


