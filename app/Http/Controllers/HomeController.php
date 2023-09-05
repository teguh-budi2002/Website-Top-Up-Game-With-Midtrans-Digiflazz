<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\NavLayout;
use App\Models\CustomField;
use App\Models\DiscountProduct;
use App\Models\FlashSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Repositories\Product\ProductRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
  public function __construct() {
    $getNavLayouts = DB::table('nav_layouts')->selectRaw("id, text_head_nav")->first();
    View::share('navigation', $getNavLayouts);
  }

  public function index()
  {
    $flashsales = Cache::remember('flashsale', 30, function () {
      return DB::table('flash_sales')
                ->select('flash_sales.id', 'flash_sales.start_time', 'flash_sales.end_time', 'flash_sales.is_flash_sale',
                        'discount_products.id as discount_product_id', 'discount_products.discount_fixed', 'discount_products.discount_flat', 'discount_products.type_discount', 'discount_products.price_after_discount', 
                        'products.id as product_id', 'products.product_name', 'products.img_url', 'products.slug',
                        'items.id as item_id', 'items.item_name', 'items.nominal', 'items.price')
                ->join('flashsale_discount_items', 'flash_sales.id', '=', 'flashsale_discount_items.flashsale_id')
                ->join('items', 'flashsale_discount_items.item_id', 'items.id')
                ->join('discount_products', 'flashsale_discount_items.item_id', '=', 'discount_products.item_id')
                ->join('products', 'discount_products.product_id', '=', 'products.id')
                ->where('flash_sales.is_flash_sale', '=', 1)
                ->get();
    });

    return view('Main', [
      'flash_sales' => $flashsales
    ]);
  }

  /**
   * Show Product Ordered
   */
  public function orderProduct($productOrdered) 
  {
    $getCustomField = CustomField::wherepageSlug($productOrdered)->first();
    $getProductOrdered = ProductRepository::getProductForOrder($productOrdered);

    return view('Order', [
      'product' => $getProductOrdered,
      'custom_field' => $getCustomField
    ]);
  }

  public function checkoutProduct($invoice) {
    $getDetailOrder = Order::with(['product:id,product_name', 'payment:id,img_static'])->whereInvoice($invoice)->first();
    if (is_null($getDetailOrder)) {
      return redirect('/')->with('order-invalid', 'Checkout Pada Order Invalid.');
    }
    return view('Checkout', ['detail_order' => $getDetailOrder]);
  }
}
