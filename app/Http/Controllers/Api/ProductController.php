<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function getAllProducts() {
        try {
            $getALlProducts = Product::select("id", "product_name")->get();
    
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
}
