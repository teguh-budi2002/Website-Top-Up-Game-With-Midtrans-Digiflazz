<?php

namespace App\Services\Marketplace\Digiflazz;

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
      'username'  => env('USERNAME_DIGIFLAZZ'),
      // 'buyer_sku_code'  =>  'xld10', // TEST
      'buyer_sku_code'  =>  $currentOrder->code_item,
      // 'customer_no'     =>  '087800001230', //TEST
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

    return $decodeResponse;
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