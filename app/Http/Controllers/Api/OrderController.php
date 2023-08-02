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
            'data' => $checkout,
            'status' => 'success'
          ], 201);
          DB::commit();
        } catch (\Throwable $th) {
          DB::rollback();
          return response()->json([
            'message' => 'Checkout Gagal. Maaf Kesalahan Di Sisi Server',
            'data' => $checkout,
             'status' => 'error'
          ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function showOrder($id)
    {
      try {
          $orderDetail = Order::with('payment')->where('id', $id)->firstOrFail();
          $chargeOrder = MidtransServices::chargeOrder($orderDetail);

          return response()->json([
            'message' => 'Product Ordered',
            'status' => 'success'
            // 'order' => $order->with('product')->first(),
          ], 200);
      } catch (\Throwable $th) {
        return response()->json([
          'message' => 'Error In Server Side ' . $th->getMessage(),
          'status' => 'error'
        ], 500);
      }
   
    }
}
