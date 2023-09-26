<?php

use App\Http\Controllers\Api\ItemApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TokenController;
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
Route::get('get-token', [TokenController::class, 'token'])->withoutMiddleware('api.security');

Route::middleware(['api.refresh_token', 'api.security'])->group(function() {
    // Finding Data Resource
    Route::get('find-product-with-livesearch', [ProductController::class, 'liveSearchData']);
    Route::get('get-products', [ProductController::class, 'getAllProducts']);
    
    Route::post('get-items-by-product', [ItemApiController::class, 'getItemsByProductId']);

    Route::prefix('order')->group(function() {
        Route::post('{order}', [OrderController::class, 'createOrder']);  
        Route::get('/purchase/status/{trx_id}', [OrderController::class, 'statusOrder'])->withoutMiddleware('api.security');  
    });
    Route::prefix('layout')->group(function() {
        Route::get('banner',[LayoutController::class, 'getBannerLayout']);
    });
});


