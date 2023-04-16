<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NominalProductController;

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

Route::get('dashboard', [DashboardController::class, 'index']);
Route::post('add-product', [ProductController::class, 'store']);
Route::get('nominal-product/{id}', [NominalProductController::class, 'index']);
Route::post('add-nominal-item', [NominalProductController::class, 'addNominal']);

Route::get('order', [OrderController::class, 'create']);
Route::post('checkout', [OrderController::class, 'store']);
Route::get('order-payment/{order:id}', [OrderController::class, 'show']);
