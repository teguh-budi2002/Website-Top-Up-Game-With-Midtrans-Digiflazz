<?php

namespace App\Repositories\Interfaces\Product;

interface ProductRepositoryInterface
{
  public static function searchProduct($request);
  public static function findResourceWithLiveSearch($request);
}
