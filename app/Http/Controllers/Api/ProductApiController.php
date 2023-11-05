<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CategoryProduct;
use App\Repositories\Product\ProductRepository;
use Illuminate\Support\Facades\DB;

class ProductApiController extends BaseApiController
{
    public function getAllProducts() {
        try {
            $getALlProducts = Product::select("id", "product_name", "img_url", "slug", "is_testing")
                                      ->where("published", 1)
                                      ->take(10)
                                      ->get();
            return $this->success_response("Get Data is Successfull", 200, $getALlProducts);
        } catch (\Throwable $th) {
            return $this->failed_response("ERROR IN SERVER SIDE!");
        }
    }

    public function getProductByCategory(Request $request) {
      try {
        $productByCategory = DB::table('products')
                                ->select("id", "category_id", "product_name", "img_url", "slug", "is_testing")
                                ->when($request->category_id != 1, function ($query) use ($request) {
                                    $query->where("category_id", $request->category_id);
                                })
                                // ->whereCategoryId($request->category_id)
                                ->where('published', 1)
                                ->orderBy('id')
                                ->paginate(10)
                                ->appends([
                                  'category_id' => $request->category_id
                                ]);

        if ($productByCategory->isNotEmpty()) {
          return $this->success_response("Get Product By Category is Successfully", 200, $productByCategory);
        } else {
          return $this->success_response("Get Product By Category is Not Found", 404, $request->all());
        }
      } catch (\Throwable $th) {
        return $this->failed_response("ERROR IN SERVER SIDE!" . $th->getMessage());
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
