<?php 

namespace App\Services\Whatsapp;

use GuzzleHttp\Client;

class WhatsappService {
  protected static $endpoint = 'https://api.fonnte.com/send';

  public static function sendToCustomer($phone_number, $detail_order) {
    try {
      $client = new Client();
      $response = $client->request('POST', self::$endpoint, [ 
        'headers' => [
          'Authorization' => env('FONTEE_TOKEN'),
        ],
        'json'  => [
          'target' => $phone_number,
          'message' => self::formatMessage($detail_order),
          'countryCode' => '62',
          'delay' => '120',
        ]
      ]);
    } catch (\Exception $e) {
      throw new \Exception("ERROR SRVERSIDE WHILE SEND NOTIF WA: " . $e->getMessage());
    }

    // $decodeResponse = json_decode($response->getBody(), true);
    // return $decodeResponse;
  }

  private static function formatMessage($detail_order) {
    $invoice = $detail_order->invoice;
    $product = $detail_order->product->product_name;
    $item = $detail_order->item->nominal . '-' . $detail_order->item->item_name;
    $total_amount = $detail_order->total_amount;
    $payment_type = strtoupper($detail_order->payment->payment_name);

$message = "Terimakasih telah melakukan pembelian menggunakan layanan *Guh SHOP | Lapak Murah*.

Mohon segera selesaikan pembayaran agar item yang dibeli dapat di proses dengan otomatis.

**INVOICE : $invoice**
**Produk  : $product**
**Item    : $item**
**Total Harga   : $total_amount**
**Metode Pembayaran : $payment_type**

Jika Anda memiliki pertanyaan atau memerlukan bantuan, silakan hubungi kami di nomer ini.

Detail transaksi :
https://paspayment.com/checkout/INV201023BFQNZHKNWG

*Guh SHOP | Lapak Murah*";

    return $message;
  }
}