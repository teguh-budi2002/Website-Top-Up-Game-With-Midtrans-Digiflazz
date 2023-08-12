<?php

namespace App\Http\Controllers;

use App\Models\NavLayout;
use App\Models\CustomField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Repositories\Product\ProductRepository;

class HomeController extends Controller
{

  public function __construct() {
    $getNavLayouts = NavLayout::select("id", "text_head_nav")->first();
    
    View::share('navigation', $getNavLayouts);
  }

  public function index()
  {
    return view('Main');
  }

  /**
   * Get Product for Ordered
   */
  public function orderProduct(Request $request, $productOrdered) 
  {
    $getCustomField = CustomField::wherepageSlug($productOrdered)->first();
    $getProductOrdered = ProductRepository::getProductForOrder($productOrdered);

    return view('Order', [
      'product' => $getProductOrdered,
      'custom_field' => $getCustomField,
    ]);
  }
}
