<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\PaymentGatewayProvider;
use App\Models\Transaction;
use App\Services\PaymentGateway\Midtrans\MidtransServices;
use App\Services\PaymentGateway\Tripay\TripayServices;
use App\Services\PaymentGateway\Xendit\XenditServices;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderApiController extends BaseApiController
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
         
          $orderCheckout = $this->services->checkout($request->all());
          // $orderCheckout->update(['invoice' => "ORDER-" . $orderCheckout->id . "-" . Carbon::now()->timestamp]);
          $chargeOrder = $this->services->chargeOrder($orderCheckout);

          $saveToTrx = Transaction::create([
            'trx_id'              =>  $chargeOrder['transaction_id'],
            'invoice'             =>  $chargeOrder['order_id'],
            'payment_type_trx'    =>  $chargeOrder['payment_type'],
            'transaction_time'    =>  $chargeOrder['transaction_time'],
            'transaction_expired' =>  $chargeOrder['expiry_time'],
            'transaction_status'  =>  ucfirst($chargeOrder['transaction_status']),
            'gross_amount'        =>  $chargeOrder['gross_amount'],
            'qr_code_url'         =>  $chargeOrder['actions'][0]['url'] 
          ]);
          DB::commit();
          return $this->success_response('Checkout Berhasil Ditambahkan, Silahkan Lakukan Pembayaran.', 201, $orderCheckout->invoice);
        } catch (\Exception $e) {
          DB::rollback();
          return $this->failed_response('Checkout Gagal. Maaf Kesalahan Di Sisi Server.' . $e->getMessage());
        }
    }

    public function statusOrder($trx_id) {
        try {
          $statusOrder = $this->services->getStatusOrder($trx_id);
          return $this->success_response('Status Order', 200, $statusOrder);
        } catch (\Exception $e) {
          return $this->failed_response('Gagal Mendapatkan Status Order. Maaf Kesalahan Di Sisi Server.');
        }
    }

    public function getDetailOrder($invoice) {
        try {
          $detailOrder = Order::with(['product:id,product_name', 'payment:id,img_static', 'item:id,item_name,nominal'])->whereInvoice($invoice)->first();
          if (is_null($detailOrder)) {
            return redirect('/')->with('order-invalid', 'Order Tidak Ditemukan.');
          }
  
          $detailTrx   = Transaction::select("id", "transaction_time", "transaction_expired", "transaction_status", "qr_code_url")
                                    ->where('invoice', $detailOrder->invoice)
                                    ->first();
          return $this->success_response("Berhasil Mendapatkan Detail Order", 200, ['detail_order' => $detailOrder, 'detail_trx' => $detailTrx]);
        } catch (\Throwable $th) {
          return $this->failed_response("Gagal Mendapatkan Detail Order. Maaf Kesalahan Di Sisi Server.");
        }
    }

    public function httpNotifCallback(Request $request) {
      try {
        $handleCallback = $this->services->callbackNotifMidtrans($request);
        return $this->success_response('PING! Notification Dari Pihak Midtrans', 200);
      } catch (\Exception $e) {
        return $this->failed_response('Kesalahan Di Sisi Server: ' . $e->getMessage());
      }
    }
}
