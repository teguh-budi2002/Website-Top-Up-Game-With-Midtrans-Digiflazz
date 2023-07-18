<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Layout\LayoutController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Finding Data Resource
Route::get('find-product-with-livesearch', [ProductController::class, 'liveSearchData']);

Route::get('get-products', [ProductController::class, 'getAllProducts']);
Route::prefix('order')->group(function() {
    Route::post('{order}', [OrderController::class, 'createOrder']);

});

Route::prefix('layout')->group(function() {
    Route::get('banner',[LayoutController::class, 'getBannerLayout']);
});
