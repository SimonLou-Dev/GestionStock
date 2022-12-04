<?php

use App\Http\Controllers\StockController;
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

Route::get('/', [StockController::class, 'index'])->name('index');

Route::get('/product/add', [StockController::class, 'add'])->name('product.add');
Route::get('/product/remove', [StockController::class, 'remove'])->name('product.remove');
Route::post('/remove/product/', [StockController::class, 'destroy'])->name('product.destroy');
Route::post('/add/product/post', [StockController::class, 'store'])->name('product.add.post');


Route::get('/add/item/{id}/{space}', [StockController::class, 'additem'])->name('add.item');
Route::get('/remove/item/{id}/{space}', [StockController::class, 'removeitem'])->name('remove.item');


