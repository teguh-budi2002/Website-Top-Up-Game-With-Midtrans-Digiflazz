<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\Interfaces\Product\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{

  public static function findProductBySlugOrId($key, $request) {
    return Product::where($key, $request)->first();
  }

  public static function getProductForOrder($slug) {
    $product = Product::select("id", "slug", "product_name", "img_url", "item_img", "is_testing", "code_product")
                        ->with(["items:id,product_id,item_name,nominal,price", "paymentMethods:id,payment_name,img_static,is_recommendation", 'paymentMethods.fee', 'items.discount' => function($q) {
                          $q->where('status_discount', 1);
                        }])
                        ->whereSlug($slug)
                        ->first();
    return $product;
  }
  /**
   * Find Data Resource For Dashboard
   */
  public static function searchProduct($req_search)
  {
    $data_searching = Product::with(['items', 'category:id,name_category', 'paymentMethods:id,img_static,payment_name'])
      ->where('product_name', 'LIKE', '%' . $req_search . '%')
      ->paginate(10);
    return $data_searching;
  }

  /**
   * Find Data Resource For Live Search In Home Page
   */
  public static function findResourceWithLiveSearch($req_search)
  {
    $data_searching = Product::select("id", "product_name", 'slug')
      ->where('product_name', 'LIKE', '%' . $req_search . '%')
      ->where("published", 1)
      ->get();
    return $data_searching;
  }
}
