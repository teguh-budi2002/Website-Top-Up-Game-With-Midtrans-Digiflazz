<?php

namespace App\Repositories\Interfaces\Product;

interface ProductRepositoryInterface
{
  public static function findProductBySlugOrId($key, $request);
  public static function getProductForOrder($slug);
  public static function searchProduct($request);
  public static function findResourceWithLiveSearch($request);
}
