<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemApiController extends BaseApiController
{
     public function getItemsByProductId(Request $request) {
      try {
        if ($request->has('product_id')) {
            $product_id = $request->product_id;
            $itemProduct = Item::whereProductId($product_id)->get();
            
            return $this->success_response('Get Item Successfully', $itemProduct, config('token.SECRET_TOKEN'));
        }
      } catch (\Throwable $th) {
        return $this->failed_response('ERROR SERVER: ' . $th->getMessage());
      }
    }
}
