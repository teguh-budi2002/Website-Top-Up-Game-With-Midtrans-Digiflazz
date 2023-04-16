<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
      $products = Product::with('items')->get();
      return view('dashboard.index', ['products' => $products]);
    }
}
