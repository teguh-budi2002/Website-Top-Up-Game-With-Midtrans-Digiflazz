<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\NavLayout;
use App\Models\PaymentFee;
use App\Models\CustomField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
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

  protected static function breadcrumbs() {
    $breadcrumbs = [];
    $currentRoute = Route::getCurrentRoute()->getName();
    $routeParts = explode(',', $currentRoute);

    $breadcrumbsHistory = Session::get('route_history', []);
    if (empty($breadcrumbsHistory)) {
      array_push($breadcrumbsHistory, $currentRoute);
      Session::put('route_history', $breadcrumbsHistory);
    }

    $url = '';
    foreach ($breadcrumbsHistory as $route) {
        $url .= '/' . $route;
        $breadcrumbs[] = [
            'name' => str_replace('-', ' ', $route),
            'url' => $url,
        ];
    }
  return $breadcrumbs;
  }
}
