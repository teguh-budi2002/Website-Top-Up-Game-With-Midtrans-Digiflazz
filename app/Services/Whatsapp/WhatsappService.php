<?php 

namespace App\Services\Whatsapp;

use GuzzleHttp\Client;

class WhatsappService {
  protected static $endpoint = 'https://api.fonnte.com/send';
  public static $typeNotif;
  public static $detailNotif;

  public static function typeNotif($type) {
      self::$typeNotif = $type;
      return new static(); 
  }

  public static function setData($data) { 
      self::$detailNotif = $data;
      return new static();
  }

  function sendToCustomer($phone_number) {
    try {
      $client = new Client();
      $response = $client->request('POST', self::$endpoint, [ 
        'headers' => [
          'Authorization' => env('FONTEE_TOKEN'),
        ],
        'json'  => [
          'target' => $phone_number,
          'message' => self::message(),
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

  private static function message() {
    $dataNotif = self::$detailNotif;
    $typeNotif = self::$typeNotif;

    if ($typeNotif === 'order_created') {
      return self::formatMessageOrder($dataNotif);
    } elseif ($typeNotif === "user_created") { 
      return self::formatMessageAddUser($dataNotif);
    }
  }

  private static function formatMessageOrder($order) { 
      $invoice = $order->invoice;
      $product = $order->product->product_name;
      $item = $order->item->nominal . '-' . $order->item->item_name;
      $total_amount = $order->total_amount;
      $payment_type = strtoupper($order->payment->payment_name);
  
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

  private static function formatMessageAddUser($data) { 
    $userUsername = $data['username'];
    $userPassword = $data["password"];
    $userFullname = $data['fullname'];
    $role = $data['role_id'];
    $url = $role == 3 ? env('APP_URL') . '/login/member' : env('APP_URL') . '/login/dashboard-main';

    $message = "Hello, **$userFullname** terimakasih telah mendaftar menjadi bagian dari perusahaan kami, berikut adalah username dan password kamu.
    Username: **$userUsername**
    Passowrd: **$userPassword**

    Mohon untuk tidak membagikan data pribadi kamu terhadap siapapun, jika pengguna melakukan pelanggaran maka admin berhak untuk **ME-NONAKTIFKAN** akun kamu.

    Untuk mengakses halaman Dashboard, silakan kunjungi $url untuk melakukan login.
    Harap mengganti password lama dengan password yang baru.

    Hormat kami, *Guh SHOP | Lapak Murah*
    ";

    return $message;
  }
}