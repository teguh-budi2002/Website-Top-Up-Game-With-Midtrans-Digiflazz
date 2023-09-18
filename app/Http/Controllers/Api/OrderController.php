<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreOrderRequest;
use App\Models\PaymentGatewayProvider;
use App\Services\PaymentGateway\Midtrans\MidtransServices;
use App\Services\PaymentGateway\Tripay\TripayServices;
use App\Services\PaymentGateway\Xendit\XenditServices;

class OrderController extends BaseApiController
{
  protected $services;

    public function __construct() {
      try {
        $this->initServices();
      } catch (\Exception $e) {
        throw new \Exception("Maaf Kesalahan Di Sisi Server: Invalid Payment Gateway Provider. Mohon Kontak Admin!");
      }
    }

    private function initServices() {
        $provider = PaymentGatewayProvider::where('status', 1)->first();
        switch ($provider->payment_name) {
          case 'midtrans':
            $this->services = new MidtransServices($provider);
            break;
          case 'tripay':
            $this->services = new TripayServices;
            break;
          case 'xendit':
            $this->services = new XenditServices;
            break;
        }
        $this->services->init($provider);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createOrder(StoreOrderRequest $request)
    {
        $validation = $request->validated();
        DB::beginTransaction();
        try {
         
          $checkout = $this->services->checkout($request->all());
          DB::commit();
          return $this->success_response('Checkout Berhasil Ditambahkan, Silahkan Lakukan Pembayaran.', 201, $checkout);
        } catch (\Exception $e) {
          DB::rollback();
          return $this->failed_response('Checkout Gagal. Maaf Kesalahan Di Sisi Server.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function purchaseOrder($id)
    {
      try {
          $orderDetail = Order::with(['payment', 'product'])->whereId($id)->first();
          if (empty($orderDetail)) {
            return $this->failed_response('Detail Order Tidak Ditemukan', 404);
          }

          $chargeOrder = $this->services->chargeOrder($orderDetail);
          return $this->success_response("Pembayaran Order Telah Berhasil. Silahkan tunggu beberapa saat untuk menerima item games.", 200, $chargeOrder);
      } catch (\Throwable $th) {
        return $this->failed_response('ERROR IN SERVER SIDE: ' . $th->getMessage());
      } catch (\RuntimeException $re) {
          return $this->failed_response('Pembayaran Gagal. Maaf Kesalahan Di Sisi Server: ' . $re->getMessage());
        }
   
    }
}
