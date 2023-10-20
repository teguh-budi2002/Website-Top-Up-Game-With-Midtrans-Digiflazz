<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Layout\LayoutController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DiscountProductController;
use App\Http\Controllers\FlashSaleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentFeeController;
use App\Http\Controllers\PaymentGatewayProviderController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\SEOController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('order/{slug}', [HomeController::class, 'orderProduct'])->name('order');
Route::get('checkout/{invoice}', [HomeController::class, 'checkoutProduct'])->name('checkout');
Route::get('notifikasi/{slug}', [NotificationController::class, 'displayNotif'])->name('notification');

Route::prefix('dashboard')->group(function () {
  Route::get('/', [DashboardController::class, 'index']);
  Route::get('/website/order-page/setting', [DashboardController::class, 'manage_website']);
  Route::get('/products', [DashboardController::class, 'manage_product_pages']);
  Route::get('/payment-product', [DashboardController::class, 'manage_payment_product']);
  Route::get('/payment-fee', [DashboardController::class, 'manage_payment_fee']);
  Route::get('/discount', [DashboardController::class, 'manage_discount']);
  Route::get('/list-discount', [DashboardController::class, 'list_product_discount']);

  // Custom Order Page
  Route::post('order-page/setting', [WebsiteController::class, 'settingCustomOrderPage']);

  //Product
  Route::resource('product', ProductController::class);
  Route::delete('delete-checked-products', [ProductController::class, 'deleteManyResource']);
  Route::patch('published-product/{product_id}', [ProductController::class, 'publishProduct']);
  Route::patch('unpublished-product/{product_id}', [ProductController::class, 'unpublishProduct']);

  // Item
  Route::post('/item/store', [ItemController::class, 'storeItem']);

  //Payment Method
  Route::post('/add-payment-method', [PaymentController::class, 'handleAddPaymentMethodIntoProduct']);
  Route::post('/add-recommendation-payment-method', [PaymentController::class, 'handleRecommendationPaymentMethod']);
  Route::put('/remove-recommendation-payment-method/{payment_id}', [PaymentController::class, 'handleRemoveRecommendationPaymentMethod']);

  //  Payment Fee
  Route::post('/add-payment-fee', [PaymentFeeController::class, 'handlePaymentFee']);

  // Discount Product
  Route::post('/add-discount-to-product', [DiscountProductController::class, 'addDiscountIntoItemProduct']);
  Route::patch('/activate-discount/{item_id}', [DiscountProductController::class, 'activatedDiscount']);
  Route::patch('/deactive-discount/{item_id}', [DiscountProductController::class, 'deactiveDiscount']);
  Route::delete('/delete-discount/{item_id}', [DiscountProductController::class, 'deleteDiscount']);
  
  //  FlashSale
  Route::post('/add-flash-sale', [FlashSaleController::class, 'handleFlashSale']);
  Route::patch('/active-flashsale/{flashsale_id}', [FlashSaleController::class, 'activateFlashsale']);
  Route::patch('/deactive-flashsale/{flashsale_id}', [FlashSaleController::class, 'deactiveFlashsale']);
  Route::delete('/delete-flashsale/{flashsale_id}', [FlashSaleController::class, 'deleteFlashsale']);

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
    Route::get('banner', [LayoutController::class, 'editBannerLayout']);
    Route::post('main/banner/edit', [LayoutController::class, 'editMainBannerLayout']);
  });

  Route::prefix('settings')->group(function() {
    Route::get('seo', [DashboardController::class, 'manage_seo_website']);
    Route::post('add-or-update-seo', [SEOController::class, 'addOrUpdateSeo']);

    Route::get('provider', [DashboardController::class, 'manage_provider']);
    Route::post('/provider/add-or-update-provider', [ProviderController::class, 'addOrUpdateProvider']);
    Route::post('/provider/activated-provider/{id}', [ProviderController::class, 'activatedProvider']);
    Route::post('/provider/deactive-provider/{id}', [ProviderController::class, 'deactiveProvider']);

    Route::get('payment-gateway', [DashboardController::class, 'manage_payment_gateway']);
    Route::post('/payment-gateway/add-or-update-pg', [PaymentGatewayProviderController::class, 'addOrUpdatePG']);
    Route::post('/payment-gateway/activated-pg/{id}', [PaymentGatewayProviderController::class, 'activatedPG']);
    Route::post('/payment-gateway/deactive-pg/{id}', [PaymentGatewayProviderController::class, 'deactivePG']);

    Route::get('notifications', [DashboardController::class, 'manage_notification']);
    Route::post('/notifications/add-or-update-notif', [NotificationController::class, 'addOrUpdateNotif']);
  });
});
