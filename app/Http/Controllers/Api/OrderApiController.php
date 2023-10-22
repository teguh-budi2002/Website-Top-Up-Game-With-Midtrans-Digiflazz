<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\PaymentGatewayProvider;
use App\Models\Transaction;
use App\Services\CheckIDGames\CheckIDGames;
use App\Services\PaymentGateway\Midtrans\MidtransServices;
use App\Services\PaymentGateway\Tripay\TripayServices;
use App\Services\PaymentGateway\Xendit\XenditServices;
use App\Services\Whatsapp\WhatsappService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderApiController extends BaseApiController
{
  protected $services;
  protected $username_game_validation;

    public function __construct() {
      $this->username_game_validation = new CheckIDGames;
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
        $this->services->init();
    }

    // public function testWA() {
    //   $wa = WhatsappService::sendToCustomer('083834819552', []);
    //   return $this->success_response('Berhasil Dikirim', 200, $wa);
    // }

    public function checkUsernameGame(Request $request) {
      $codeGame = $request->code_game;
      $IDgame = $request->player_id;
      $ZoneID = $request->zone_id;
      try {
        $checkingGameID = $this->username_game_validation->checkIDGame($codeGame, $IDgame, $ZoneID);

        if (isset($checkingGameID['RESULT_CODE']) && $checkingGameID['RESULT_CODE'] == '10001') {
          return $this->failed_response("Server Sedang Sibuk, Mohon Tunggu Beberapa Detik dan Coba Lagi.", 429);
        } else {
            if (isset($checkingGameID['success']) && empty($checkingGameID['errorMsg'])) {
                return $this->success_response(" Berhasil Check ID Game", 200,  ['User-ID' => $checkingGameID['confirmationFields']['username'], 'IS_USER_VALID' => $checkingGameID['isUserConfirmation']]);
            } else {
                return $this->failed_response("ID Game Tidak Ditemukan", 400);
            }
        }
      } catch (\Exception $e) {
        return $this->failed_response("ERROR CHECK USERNAME GAME: " . $e->getMessage(), 500);
      }
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
          $chargeOrder = $this->services->chargeOrder($orderCheckout);
          $saveToTrx = self::saveToTransaction($chargeOrder);
          $sendNotifToCustomer = WhatsappService::sendToCustomer($request->phone_number, $orderCheckout);
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
  
          $detailTrx   = Transaction::select("id", "transaction_time", "transaction_expired", "transaction_payment_status", "transaction_order_status", "qr_code_url")
                                    ->where('invoice', $detailOrder->invoice)
                                    ->first();
          return $this->success_response("Berhasil Mendapatkan Detail Order", 200, ['detail_order' => $detailOrder, 'detail_trx' => $detailTrx]);
        } catch (\Throwable $th) {
          return $this->failed_response("Gagal Mendapatkan Detail Order. Maaf Kesalahan Di Sisi Server." . $th->getMessage());
        }
    }

    public function httpNotifCallback(Request $request) {
      try {
        $handleCallback = $this->services->callbackNotifPaymentGateway(json_decode($request->getContent(), TRUE));
        return $this->success_response('PING! Notification Dari Pihak Midtrans', 200);
      } catch (\Exception $e) {
        return $this->failed_response('Kesalahan Di Sisi Server: ' . $e->getMessage());
      }
    }

    private static function saveToTransaction($chargeOrder) {
      $url = '';
      $va_number = '';
      $bank_name = '';

      if (isset($chargeOrder['actions']) && isset($chargeOrder['actions'][0])) {
        if ($chargeOrder['actions'][0]['name'] === 'deeplink-redirect') {
          // Deeplink Shopee Redirect
          $url = $chargeOrder['actions'][0]['url'];
        } elseif ($chargeOrder['actions'][0]['name'] === 'generate-qr-code') {
          //  QR Code URL
          $url = $chargeOrder['actions'][0]['url'];
        }
      }

      switch ($chargeOrder) {
        // BCA && BRI && BNI
        case array_key_exists('va_numbers', $chargeOrder):
          $va_number = $chargeOrder['va_numbers'][0]['va_number'];
          $bank_name = $chargeOrder['va_numbers'][0]['bank'];
          break;
        // Permata
        case array_key_exists('permata_va_number', $chargeOrder):
          $va_number = $chargeOrder['permata_va_number'];
          $bank_name = 'permata';
          break;
        // CIMB
        case array_key_exists('approval_code', $chargeOrder):
          $va_number = $chargeOrder['approval_code'];
          $bank_name = 'cimb';
          break;
      }

      Transaction::create([
        'trx_id'              =>  $chargeOrder['transaction_id'],
        'invoice'             =>  $chargeOrder['order_id'],
        'payment_type_trx'    =>  $chargeOrder['payment_type'],
        'transaction_time'    =>  $chargeOrder['transaction_time'],
        'transaction_expired' =>  $chargeOrder['expiry_time'],
        'transaction_payment_status'  =>  ucfirst($chargeOrder['transaction_status']),
        'transaction_order_status'    =>  'Waiting',
        'gross_amount'        =>  $chargeOrder['gross_amount'],
        'qr_code_url'         =>  $url,
        'va_number'           =>  $va_number,
        'bank_name'           =>  $bank_name,
      ]);
    }
}
