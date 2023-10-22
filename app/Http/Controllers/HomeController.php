<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use App\Models\Order;
use App\Models\NavLayout;
use App\Models\CustomField;
use App\Models\DiscountProduct;
use App\Models\FlashSale;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Repositories\Product\ProductRepository;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
  public function __construct() {
    $getNavLayouts = DB::table('nav_layouts')->selectRaw("id, text_head_nav")->first();
    View::share('navigation', $getNavLayouts);
  }

  protected function getAccessAPIToken() {
    $client = new Client();
    $response = $client->get(config('token.API_URL_GET_TOKEN') . '/api/get-token');
    $decodeResponse = json_decode($response->getBody(), TRUE);
    $token = $decodeResponse['data'];

    return $token;
  }

  public function index()
  {
    $isFlashsaleActive = DB::table('flash_sales')->select('is_flash_sale')->where('is_flash_sale', 1)->exists();
    if ($isFlashsaleActive) {
      $flashsales = Cache::remember('flashsale', 3600, function () {
        return DB::table('flash_sales')
                  ->select('flash_sales.id', 'flash_sales.start_time', 'flash_sales.end_time', 'flash_sales.is_flash_sale',
                          'discount_products.id as discount_product_id', 'discount_products.discount_fixed', 'discount_products.discount_flat', 'discount_products.type_discount', 'discount_products.price_after_discount', 
                          'products.id as product_id', 'products.product_name', 'products.img_url', 'products.slug', 'products.is_testing',
                          'items.id as item_id', 'items.item_name', 'items.nominal', 'items.price')
                  ->join('flashsale_discount_items', 'flash_sales.id', '=', 'flashsale_discount_items.flashsale_id')
                  ->join('items', 'flashsale_discount_items.item_id', 'items.id')
                  ->join('discount_products', 'flashsale_discount_items.item_id', '=', 'discount_products.item_id')
                  ->join('products', 'discount_products.product_id', '=', 'products.id')
                  ->where('flash_sales.is_flash_sale', '=', 1)
                  ->get();
      });
    }

    $product_categories = Cache::remember('category', now()->addDay(), function() {
        return DB::table('category_products')
                  ->select("id", "name_category")
                  ->get();
    }); 

    $getAccessApiToken = $this->getAccessAPIToken();
    return view('Main', [
      'flash_sales' => isset($flashsales) ? $flashsales : [],
      'product_categories'  => $product_categories,
      'token' => $getAccessApiToken
    ]);
  }

  /**
   * Show Product Ordered
   */
  public function orderProduct($productOrdered) 
  {
    $getCustomField = CustomField::wherepageSlug($productOrdered)->first();
    $getProductOrdered = ProductRepository::getProductForOrder($productOrdered);
    $getAccessApiToken = $this->getAccessAPIToken();

    return view('Order', [
      'product' => $getProductOrdered,
      'custom_field' => $getCustomField,
      'token' => $getAccessApiToken
    ]);
  }

  public function checkoutProduct($invoice) {
    $checkOrderIsExist = Transaction::where('invoice', $invoice)->exists();
    if (!$checkOrderIsExist) {
      return redirect('/');
    }

    return view('Checkout', [
      'invoice' => $invoice
    ]);
  }
}
