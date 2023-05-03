<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\Interfaces\Product\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
  /**
   * Find Data Resource For Dashboard
   */
  public static function searchProduct($req_search)
  {
    $data_searching = Product::with('items')
      ->where('product_name', 'LIKE', '%' . $req_search . '%')
      ->paginate(10);
    return $data_searching;
  }

  /**
   * Find Data Resource For Live Search In Home Page
   */
  public static function findResourceWithLiveSearch($req_search)
  {
    $data_searching = Product::select("id", "product_name")
      ->where('product_name', 'LIKE', '%' . $req_search . '%')
      ->get();
    return $data_searching;
  }
}
