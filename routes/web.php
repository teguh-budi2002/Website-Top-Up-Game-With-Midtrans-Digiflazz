<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\ItemController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

// Finding Data Resource
Route::get('find-product-with-livesearch', [HomeController::class, 'liveSearchData']);

Route::prefix('dashboard')->group(function () {
  Route::get('/', [DashboardController::class, 'index']);
  Route::get('/products', [DashboardController::class, 'manage_product_pages']);

  //Product
  Route::resource('product', ProductController::class);
  Route::delete('delete-checked-products', [ProductController::class, 'deleteManyResource']);

  // Item
  Route::post('/item/store', [ItemController::class, 'storeItem']);
});
