<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\MidtransServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreOrderRequest;

class OrderController extends Controller
{
    public function __construct() {
        MidtransServices::init();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createOrder(StoreOrderRequest $request)
    {
        $validation = $request->validated();
        DB::beginTransaction();
        try {
          $checkout = MidtransServices::checkout($request->all());
          return response()->json([
            'message' => 'Checkout Berhasil Ditambahkan, Silahkan Lakukan Pembayaran.',
            'data' => $checkout
          ], 201);
          DB::commit();
        } catch (\Throwable $th) {
          DB::rollback();
          return response()->json([
            'message' => 'Checkout Gagal. Maaf Kesalahan Di Sisi Server',
            'data' => $checkout
          ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function showOrder(Order $order)
    {
      $snapToken = $order->snap_token;
      // Checking Snap Token Every Customer
      if (is_null($snapToken)) {
          $createSnapToken = MidtransServices::getSnapToken($order);
          // Save Token Into DB
          $order->snap_token = $createSnapToken;
          $order->save();
      }

      return response()->json([
        'message' => 'Product Ordered',
        'snapToken' => $snapToken,
        'order' => $order->with('product')->first(),
      ]);
    }
}
