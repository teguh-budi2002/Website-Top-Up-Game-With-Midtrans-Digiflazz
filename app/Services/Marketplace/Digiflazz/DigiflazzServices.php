<?php

namespace App\Services\Marketplace\Digiflazz;

use App\Models\Transaction;
use App\Services\Marketplace\Marketplace;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class DigiflazzServices extends Marketplace{

  protected static $endpoint = 'https://api.digiflazz.com/v1/transaction';
  protected static $provider;

  public function __construct($provider) {
    self::$provider = $provider;
  }

  public function getProductListFromMarketplace() {

  }

  public function transactionMarketplace($notifBody) {
    $endpoint = self::$endpoint;
    $ref_id = self::generateRefId();
    $currentOrder = DB::table('orders')
                      ->select("orders.id", "orders.player_id", "orders.zone_id", "orders.item_id", "items.id", "items.code_item")
                      ->where('invoice', $notifBody['order_id'])
                      ->join('items', 'items.id', '=', 'orders.item_id')
                      ->first();
                 
    $headers = [
      'Accept' => 'application/json',
      'Content-Type' => 'application/json'
    ];

    $payload = [
      'username'        =>  self::$provider->username,
      // 'buyer_sku_code'  =>  'xld10', // TEST
      // 'customer_no'     =>  '087800001233', //TEST
      'buyer_sku_code'  =>  $currentOrder->code_item,
      'customer_no'     =>  $currentOrder->player_id && $currentOrder->zone_id ? $currentOrder->player_id . " + " . $currentOrder->zone_id : $currentOrder->player_id,
      'ref_id'          =>  $ref_id,
      'sign'            =>  self::getSign($ref_id),
      'testing'         =>  env('DIGIFLAZZ_TESTING_ENV'),
    ];
    
    $client = new Client();
    $response = $client->post($endpoint, [
      'headers' => $headers,
      'json'    => $payload
    ]);

    if ($response->getStatusCode() === 400) {
        $errorMessage = json_decode($response->getBody()->getContents(), TRUE);
        throw new \Exception('ERROR 400 Bad Request: ' . $errorMessage);
    }

    $decodeResponse = json_decode($response->getBody()->getContents(), TRUE);
    $currentTrx =  Transaction::where('invoice', $notifBody['order_id'])
                             ->where('trx_id', $notifBody['transaction_id'])
                             ->first();
    if (isset($decodeResponse) && $decodeResponse['data']['status'] === "Pending") {
       $currentTrx->transaction_order_status = "Process";
    } elseif(isset($decodeResponse) && $decodeResponse['data']['status'] === "Sukses") {
      $currentTrx->transaction_order_status = "Sukses";
    } elseif(isset($decodeResponse) && $decodeResponse['data']['status'] === "Gagal") {
      $currentTrx->transaction_order_status = "Gagal";
    }

    $currentTrx->ref_id = $decodeResponse['data']['ref_id'];
    $currentTrx->save();                         

    return $decodeResponse;
  }

  public function handleCallbackMarketplace($callbackBody, $headers) {
    $secret = 'lapakmurahteguh';
    $signature = hash_hmac('sha1', json_encode($callbackBody), $secret);
    if ($headers['x-hub-signature'][0] === 'sha1=' . $signature) {
      if ($headers['x-digiflazz-event'][0] === "update") {
        if ($callbackBody["data"]["status"] === "Sukses") {
          $updateStatusTrxOrder = DB::table("transactions")
                                    ->where("ref_id", $callbackBody["data"]["ref_id"])
                                    ->update([
                                      "transaction_order_status" => "Success",
                                    ]);
          return $updateStatusTrxOrder;
        } elseif ($callbackBody["data"]["status"] === "Gagal") {
          $updateStatusTrxOrder = DB::table("transactions")
                                    ->where("ref_id", $callbackBody["data"]["ref_id"])
                                    ->update([
                                      "transaction_order_status" => "Failure",
                                    ]);
          return $updateStatusTrxOrder;
        }
        
      }
    }
  }

  private static function getSign($request) {
    $sign = md5(self::$provider->username . self::$provider->key . $request);
    return $sign;
  }

  private static function generateRefId(){
    $prefix = "TRX-";
    return $prefix . uniqid();
  }
}