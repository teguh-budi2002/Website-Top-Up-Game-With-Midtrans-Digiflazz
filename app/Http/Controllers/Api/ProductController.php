<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductRepository;

class ProductController extends Controller
{
    public function getAllProducts() {
        try {
            $getALlProducts = Product::select("id", "product_name", "img_url", "slug")
                                        ->get();
    
            return response()->json([
                'message' => 'Get Data is Successfull',
                'data' => $getALlProducts
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error_reason' => $th->getMessage()
            ], 500);
        }
    }

   /**
   * Handle Request Live Search Resource
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
