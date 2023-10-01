<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductRepository;

class ProductApiController extends BaseApiController
{
    public function getAllProducts() {
        try {
            $getALlProducts = Product::select("id", "product_name", "img_url", "slug")
                                      ->where("published", 1)
                                      ->get();
       return $this->success_response("Get Data is Successfull", 200, $getALlProducts);
        } catch (\Throwable $th) {
            return $this->failed_response("ERROR IN SERVER SIDE!");
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
          return $this->failed_response('Data Not Found', 404);
        } else {
          return $this->success_response("Data Found", 200, $doSearch);
        }
      } catch (\Throwable $th) {
        return $this->failed_response("ERROR IN SERVER SIDE!");
      }
    }
  }
  
}
