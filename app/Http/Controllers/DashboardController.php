<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\Product\ProductRepository;

class DashboardController extends Controller
{
    public function index() {
      return view('dashboard.views.main');
    }

    public function manage_website() {
      $getNameAndSlugProduct = DB::table('products')->select("id", "product_name", 'slug')->get();
      $getCustomFields = DB::table('custom_fields')->select("text_title_on_order_page", "description_on_order_page", "bg_img_on_order_page", "detail_for_product")->get();

      return view('dashboard.views.manage_website.main', [
        'products' => $getNameAndSlugProduct,
        'oldCustomFields' => $getCustomFields
      ]);
    }

    public function manage_product_pages(Request $request) {

      if ($request->has('search_product')) {
        $getProduct = ProductRepository::searchProduct($request->get('search_product'));
        $getProduct->appends(['search_product' => $request->get('search_product')]);
      } else {
        $getProduct = Product::with(['items', 'paymentMethods' => function($q) {
          $q->select("payment_methods.img_static", "payment_methods.payment_name");
        }])->paginate(10);
      }
      return view('dashboard.views.manage_product.main', [
        'products' => $getProduct
      ]);

    }

    public function manage_payment_product() {
      $getPaymentMethods = DB::table("payment_methods")->select("id", "payment_name", "type_of_payment", "img_static")->get();
      $getProducts = Product::with('paymentMethods')->select("id", "product_name")->get();

      return view ('dashboard.views.manage_payment_product.main', [
        'payment_methods' => $getPaymentMethods,
        'products' => $getProducts
      ]);
    }

    public function manage_payment_fee() {
      $getAllPayments = DB::table("payment_methods")->select("id", "payment_name", "img_static")->get();
      return view('dashboard.views.manage_payment_fee.main', ['payment_methods' => $getAllPayments]);
    }
}
