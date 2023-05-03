<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Product\ProductRepository;

class HomeController extends Controller
{

  public function index()
  {
    return view('Main');
  }

  /**
   * Handle Request Search Resource In Home Page
   */
  public function liveSearchData(Request $request): object
  {
    if ($request->get('search_product')) {
      $search = $request->get('search_product');
      try {
        $doSearch = ProductRepository::findResourceWithLiveSearch($search);
        if ($doSearch->isEmpty()) {
          return response()->json([
            'id' => 0,
            'message' => 'Data Not Found',
            'status' => '404'
          ]);
        } else {
          return response()->json([
            'message' => 'Data Finding',
            'data' => $doSearch,
            'status' => '200'
          ]);
        }
      } catch (\Throwable $th) {
        return response()->json([
          'message' => 'Error In Server Side',
          'error' => $th->getMessage()
        ]);
      }
    }
  }
}
