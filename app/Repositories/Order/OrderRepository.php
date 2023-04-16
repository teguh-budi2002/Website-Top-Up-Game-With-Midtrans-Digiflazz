<?php
namespace App\Repositories\Order;
use Carbon\Carbon;
use App\Models\Order;
use App\Enums\PaymentStatusEnum;
use Illuminate\Support\Facades\Http;
use App\Repositories\Interfaces\Order\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface {

  protected static $endpoint = 'https://app.sandbox.midtrans.com/snap/v1/transactions';

  public function checkout($data) {
    $total_amount = (int)$data['qty'] * (int)$data['price'];
    return Order::create([
      'product_id' => $data['product_id'],
      'player_id' => $data['player_id'],
      'email' => $data['email'],
      'number_phone' => $data['number_phone'],
      'qty' => $data['qty'],
      'before_amount' => $data['price'],
      'total_amount' => $total_amount,
      'payment_status' => PaymentStatusEnum::Pending
    ]);
  }

  public function getSnapToken($order) {
    $transaction_detail = [
            'transaction_details' => [
                "order_id" => "ORDER-" . $order->id . "." . Carbon::now()->timestamp,
                "gross_amount" => $order->total_amount
            ],
            'item_details' => [
                [
                    'id' => 1,
                    'price' => $order->before_amount,
                    'quantity' => $order->qty,
                    'name' => $order->product->name_game,
                    "merchant_name" => env("MERCHANT_NAME"),
                ],
            ],
            'customer_details' => [
                'first_name' => 'Martin Mulyo Syahidin',
                'email' => $order->email,
                'phone' => $order->number_phone,
            ],
            'enabled_payments' => [
              "credit_card", "cimb_clicks",
              "bca_klikbca", "bca_klikpay", "bri_epay", "echannel", "permata_va",
              "bca_va", "bni_va", "bri_va", "other_va", "gopay", "indomaret",
              "danamon_online", "akulaku", "shopeepay", "kredivo", "uob_ezpay"
            ],
        ];
      $server_key = base64_encode(env("MIDTRANS_SERVER_KEY"));
      $headers = [
        'Authorization' => "Basic " . $server_key,
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
      ];

      $response = Http::withHeaders($headers)->post(self::$endpoint, $transaction_detail);
      $snap_token = json_decode($response, true);
      return $snap_token["token"];
  }
}