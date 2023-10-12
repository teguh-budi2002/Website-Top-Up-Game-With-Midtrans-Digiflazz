<?php

namespace App\Services\Marketplace\Digiflazz;

use App\Services\Marketplace\Marketplace;
use GuzzleHttp\Client;

class DigiflazzServices extends Marketplace{

  protected static $endpoint = 'https://api.digiflazz.com/v1/transaction';

  public function getProductListFromMarketplace() {

  }

  public function transactionMarketplace() {
    $endpoint = self::$endpoint;
    $ref_id = self::generateRefId();

    $headers = [
      'Accept' => 'application/json',
      'Content-Type' => 'application/json'
    ];

    $payload = [
      'username'  => env('USERNAME_DIGIFLAZZ'),
      'buyer_sku_code'  =>  'xld10', // TEST
      'customer_no'     =>  '087800001230', //TEST
      'ref_id'          =>  $ref_id,
      'sign'            =>  self::getSign($ref_id),
      'testing'         =>  true 
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
    $sign = md5(env('USERNAME_DIGIFLAZZ') . env('DEV_KEY_DIGIFLAZZ') . $request);
    return $sign;
  }

  private static function generateRefId(){
    $prefix = "TRX-";
    return $prefix . uniqid();
  }
}