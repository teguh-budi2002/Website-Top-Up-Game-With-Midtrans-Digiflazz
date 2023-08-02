<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Layout\LayoutController;
use App\Http\Controllers\Dashboard\ItemController;
use App\Http\Controllers\Dashboard\PaymentController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\WebsiteController;

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
Route::get('order/{slug}', [HomeController::class, 'orderProduct']);

Route::prefix('dashboard')->group(function () {
  Route::get('/', [DashboardController::class, 'index']);
  Route::get('/website/order-page/setting', [DashboardController::class, 'manage_website']);
  Route::get('/products', [DashboardController::class, 'manage_product_pages']);
  Route::get('/payment-product', [DashboardController::class, 'manage_payment_product']);

  // Custom Order Page
  Route::post('order-page/{product:slug}/setting', [WebsiteController::class, 'settingCustomOrderPage']);
  //Product
  Route::resource('product', ProductController::class);
  Route::delete('delete-checked-products', [ProductController::class, 'deleteManyResource']);

  // Item
  Route::post('/item/store', [ItemController::class, 'storeItem']);

  //Payment Method
  Route::post('/add-payment-method', [PaymentController::class, 'handleAddPaymentMethodIntoProduct']);

  // Layout Edit Component
  Route::prefix('layout')->group(function() {
    /*
    | --------------------------------
    | Navigation Layout
    | --------------------------------
    */
    Route::get('nav', [LayoutController::class, 'editTextHeadingNav']);
    Route::post('nav/edit', [LayoutController::class, 'editTextHeadingNavProcess']);
    /*
    | --------------------------------
    | Main Layout
    | --------------------------------
    */
    Route::get('main', [LayoutController::class, 'editMainLayout']);
    Route::post('main/banner/edit', [LayoutController::class, 'editMainBannerLayout']);
  });
});
