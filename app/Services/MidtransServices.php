<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\Order;
use App\Enums\PaymentStatusEnum;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\OrderResource;
use GuzzleHttp\Client;

class MidtransServices {

  protected static $endpoint;

  public static function init() {
      if (config('midtrans.isProd') === 'production') {
        self::$endpoint = 'https://api.midtrans.com/v2/charge';
      }
      self::$endpoint = config('midtrans.MIDTRANS_API_DEV_URL');
  }

  public static function checkout($data) {
    $total_amount = (int) $data['qty'] * (int) $data['before_amount'];
    return Order::create([
      'product_id' => $data['product_id'],
      'player_id' => $data['player_id'],
      'invoice' => $data['invoice'],
      'email' => $data['email'],
      'qty' => $data['qty'],
      'price' => (int) $data['price'],
      'before_amount' => (int) $data['price'],
      'total_amount' => $total_amount,
      'payment_status' => PaymentStatusEnum::Pending
    ]);
  }

  public static function chargeOrder($order) {

      $transaction_detail = self::adjustTransactionDetail($order);

      $server_key = base64_encode(config('midtrans.MIDTRANS_SERVER_KEY'));
      $headers = [
        'Authorization' => "Basic " . $server_key,
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
      ];
      
      $client = new Client([
        // TESTING KARENA PAKE PROXY
        'verify' => false,
        'curl' => [
          CURLOPT_PROXY => '26.4.2.1:8089',
        ]
      ]);

      $response = $client->post(self::$endpoint . "/transactions", [
        'headers' => $headers,
        'json' => $transaction_detail
      ]);

      $responseBody = $response->getBody();
      $jsonResponse = json_decode($responseBody, true);
     
      return $snap_token["token"];
  }

  private static function adjustTransactionDetail($order) {
      $transaction_detail = [
            'transaction_details' => [
                "order_id" => "ORDER-" . $order->id . "-" . Carbon::now()->timestamp,
                "gross_amount" => $order->total_amount
            ],
            'payment_type' => $order->payment->payment_name,
            $order->payment->payment_name => [
              'enable_callback' => $order->payment->callback_url ? true : false , // True Or False depends on callback URL null or not,
              'callback_url' => $order->payment->callback_url
            ],
            'item_details' => [
                [
                    'id' => $order->id,
                    'price' => $order->before_amount,
                    'quantity' => $order->qty,
                    'name' => $order->product->product_name,
                    "merchant_name" => env("APP_NAME"),
                ],
            ],
            'customer_details' => [
                'email' => $order->email ? $order->email : null,
                'phone' => $order->number_phone ? $order->number_phone : null,
            ],
            'enabled_payments' => [
              "credit_card", "cimb_clicks",
              "bca_klikbca", "bca_klikpay", "bri_epay", "echannel", "permata_va",
              "bca_va", "bni_va", "bri_va", "other_va", "gopay", "indomaret",
              "danamon_online", "akulaku", "shopeepay", "kredivo"
            ],
        ];
  }
}
