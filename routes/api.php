<?php

use App\Http\Controllers\Api\ItemApiController;
use App\Http\Controllers\Api\MarketplaceApiController;
use App\Http\Controllers\Api\NotificationApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\ProductApiController;
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
        Route::post('wa', [OrderApiController::class, 'testWA'])->withoutMiddleware('api.security');

// URL Callback Payment Method
Route::post('notification-callback', [OrderApiController::class, 'httpNotifCallback'])->withoutMiddleware(['api.security', 'api.refresh_token']); 

// URL Callback Marketplace
Route::prefix('marketplace')->group(function() {
    // URL Callback When The Payment Transaction Successfully Paid
    Route::post('/transaction', [MarketplaceApiController::class, 'transactionTopUpMarketplace'])->withoutMiddleware(['api.security', 'api.refresh_token']);
    Route::post('/callback', [MarketplaceApiController::class, 'callbackMarketplace'])->withoutMiddleware(['api.security', 'api.refresh_token']);
});  

Route::middleware(['api.refresh_token', 'api.security'])->group(function() {
    // Finding Data Resource
    Route::get('find-product-with-livesearch', [ProductApiController::class, 'liveSearchData'])->withoutMiddleware('api.security');;
    Route::get('get-products', [ProductApiController::class, 'getAllProducts']);
    Route::get('get-products-by-category', [ProductApiController::class, 'getProductByCategory']);
    
    Route::post('get-items-by-product', [ItemApiController::class, 'getItemsByProductId']);

    Route::prefix('notifications')->group(function() {
        Route::get('get-notifications', [NotificationApiController::class, 'getAllNotifications']);
    });

    Route::post('validation-id', [OrderApiController::class, 'checkUsernameGame']);

    Route::prefix('order')->group(function() {
        Route::post('{order}', [OrderApiController::class, 'createOrder']);
        Route::get('/purchase/status/{trx_id}', [OrderApiController::class, 'statusOrder'])->withoutMiddleware('api.security');
        Route::get('/detail-order/{invoice}', [OrderApiController::class, 'getDetailOrder']); 
    });

    Route::prefix('layout')->group(function() {
        Route::get('banner',[LayoutController::class, 'getBannerLayout']);
    });
});


