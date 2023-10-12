<?php
namespace App\Services\PaymentGateway\Midtrans;

use App\Services\PaymentGateway\PaymentGateway;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class MidtransServices extends PaymentGateway
{
  protected static $endpoint;
  protected $provider;

  public function __construct($provider)
  {
    $this->provider = $provider;
  }

  public static function init() {
      if (config('midtrans.isProd') === 'production') {
        self::$endpoint = 'https://api.midtrans.com/v2';
      }
      self::$endpoint = "https://api.sandbox.midtrans.com/v2";
  }

  public function chargeOrder($order) {
      if ($this->provider) {
        $transaction_detail = self::adjustTransactionDetail($order);

        $server_key = base64_encode($this->provider->server_key);
        $headers = [
          'Authorization' => "Basic " . $server_key,
          'Accept' => 'application/json',
          'Content-Type' => 'application/json'
        ];
        
        $client = new Client([
          'curl' => [CURLOPT_SSL_VERIFYPEER => false]
        ]);
  
        $response = $client->post(self::$endpoint . "/charge", [
          'headers' => $headers,
          'json'    => $transaction_detail
        ]);
  
        $responseBody = $response->getBody();
        $decodeResponse = json_decode($responseBody, true);
       
        return $decodeResponse;
      } else {
        throw new \RuntimeException('Payment Gateway Provider Not Found');
      }
  }

  public function callbackNotifMidtrans($requestBody) {
    $notifBody = json_decode($requestBody->getContent(), TRUE);

    $trx_id = $notifBody['transaction_id'];
    $trx_status = $notifBody['transaction_status'];
    $invoice = $notifBody['order_id'];
    $payment_type = $notifBody['payment_type'];

    $currentTransaction = DB::table('transactions')
                              ->where('trx_id', $trx_id)
                              ->where('payment_type_trx', $payment_type)
                              ->where('invoice', $invoice)
                              ->first();

    if (!$currentTransaction) {
      throw new \Exception('Invoice ID Not Found in Any Transaction');
    }

    DB::beginTransaction();
    try {
      switch ($trx_status) {
        case 'settlement':
          $currentTransaction->transaction_status = "Success";
          break;
  
        case 'expire':
           $currentTransaction->transaction_status = "Expired";
           break;
  
        case 'failure':
           $currentTransaction->transaction_status = "Failure";
           break;
      }
  
      $currentTransaction->save();
      DB::commit();
    } catch (\Throwable $th) {
      throw new \Exception("Services ERROR: " . $th->getMessage());
      DB::rollBack();
    }
                              
  }

  public function getStatusOrder($trx_id) {
     if ($this->provider) {
        $server_key = base64_encode($this->provider->server_key);
        $headers = [
          'Authorization' => "Basic " . $server_key,
          'Accept' => 'application/json',
          'Content-Type' => 'application/json'
        ];
        
        $client = new Client([
          'curl' => [CURLOPT_SSL_VERIFYPEER => false]
        ]);
  
        $response = $client->get(self::$endpoint . "/" . $trx_id ."/status", [
          'headers' => $headers,
        ]);
  
        $responseBody = $response->getBody();
        $decodeResponse = json_decode($responseBody, true);
       
        return $decodeResponse;
      } else {
        throw new \RuntimeException('Order Not Found');
      }
  }

  private static function adjustTransactionDetail($order) {
      $transaction_detail = [
            'transaction_details' => [
                "order_id" => $order->invoice,
                "gross_amount" => $order->total_amount
            ],
            'item_details' => [
                [
                    'id' => $order->id,
                    'price' => $order->price,
                    'quantity' => $order->qty,
                    'name' => $order->product->product_name,
                    "merchant_name" => app('seo_data')->name_of_the_company ? app('seo_data')->name_of_the_company : env("APP_NAME"),
                ],
            ],
            'customer_details' => [
                'email' => $order->email ? $order->email : null,
                'phone' => $order->number_phone ? $order->number_phone : null,
            ],
            'custom_expiry' =>  [
                'order_time' => $order->created_at->format('Y-m-d H:i:s O'),
                'expiry_duration' => 60,
                'unit' => 'minute'
            ],
        ];

      if (isset($order->payment)) {
        $transaction_detail['enabled_payments'] = [$order->payment->payment_name];
      }

      if (isset($order->payment) && $order->payment->type_of_payment === 'E-Wallet') {
        $transaction_detail['payment_type'] = $order->payment->payment_name;
        if ($order->payment->payment_name !== 'qris') {
          $transaction_detail[$order->payment->payment_name] = [
                'enable_callback' => $order->payment->callback_url ? true : false , // True Or False depends on callback URL null or not,
                'callback_url' => $order->payment->callback_url
          ];
        }
      }

      if (isset($order->payment) && $order->payment->type_of_payment === 'Bank Transfer') {
        switch ($order->payment->payment_name) {
          case 'bca':
            $transaction_detail['bank_transfer'] = ["bank" => $order->payment->payment_name];
            $transaction_detail['payment_type'] = "bank_transfer";
            break;
          case 'bni':
            $transaction_detail['bank_transfer'] = ["bank" => $order->payment->payment_name];
            $transaction_detail['payment_type'] = "bank_transfer";
            break;
          case 'bri':
            $transaction_detail['bank_transfer'] = ["bank" => $order->payment->payment_name];
            $transaction_detail['payment_type'] = "bank_transfer";
            break;
          case 'cimb':
            $transaction_detail['bank_transfer'] = ["bank" => $order->payment->payment_name];
            $transaction_detail['payment_type'] = "bank_transfer";
            break;
          case 'permata':
            $transaction_detail['payment_type'] = "bank_transfer";
            break;
          
        }
      }

      if (isset($order->payment) && $order->payment->type_of_payment === 'Over-The-Counter') {
        $transaction_detail['payment_type'] = "cstore";
        $transaction_detail['cstore'] = [
          'store'   => $order->payment->payment_name,
          'message' => "Top Up " . $order->product->product_name
        ];
      }

      if (array_key_exists('item_details', $transaction_detail)) {
        $itemDetails = [
            'item_details' => $transaction_detail['item_details'],
        ];
        $transaction_detail = array_merge($transaction_detail, $itemDetails);
      }

      return $transaction_detail;
  }
}
