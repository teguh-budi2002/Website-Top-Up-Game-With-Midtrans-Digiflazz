<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use App\Models\Product;
use App\Models\NavLayout;
use Illuminate\Http\Request;
use App\Repositories\Product\ProductRepository;
use Illuminate\Support\Facades\View;

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
  public function orderProduct($productOrdered) 
  {
    $getCustomField = CustomField::wherepageSlug($productOrdered)->first()?? null;
    $getProductOrdered = ProductRepository::getProductForOrder($productOrdered);
    return view('Order', [
      'product' => $getProductOrdered,
      'custom_field' => $getCustomField,
    ]);
  }
}
