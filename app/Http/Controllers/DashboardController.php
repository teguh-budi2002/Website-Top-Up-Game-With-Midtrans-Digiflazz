<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Repositories\Product\ProductRepository;

class DashboardController extends Controller
{
    public function index() {
      return view('dashboard.views.main');
    }

    public function manage_product_pages(Request $request) {

      if ($request->has('search_product')) {
        $getProduct = ProductRepository::searchProduct($request->get('search_product'));
        $getProduct->appends(['search_product' => $request->get('search_product')]);
      } else {
        $getProduct = Product::with('items')->paginate(10);
      }

      return view('dashboard.views.manage_product.main', [
        'products' => $getProduct
      ]);

    }
}
