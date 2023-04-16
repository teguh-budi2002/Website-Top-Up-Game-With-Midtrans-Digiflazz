<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NominalProduct;

class NominalProductController extends Controller
{
    public function index($productId) {
      return view('dashboard.nominal-product', ['productId' => $productId]);
    }

    public function addNominal(Request $req) {
      $validation = $req->validate([
                          'product_id' => 'required',
                          'price' => 'required',
                          'item_name' => 'required'
                        ]);
      NominalProduct::create($validation);

      return redirect()->back();
    }
}
