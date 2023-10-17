<?php

namespace App\Services\PaymentGateway;

use App\Models\Order;
use App\Enums\PaymentStatusEnum;
use Carbon\Carbon;

abstract class PaymentGateway {
  abstract public static function init();
  abstract public function chargeOrder($dataOrder);
  abstract public function getStatusOrder($trxId);
  abstract public function callbackNotifPaymentGateway($requst);

  protected static function createInvoice() {
    $randomStr = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $generateStr = substr(str_shuffle($randomStr), 0 ,10);
    return strtoupper($generateStr); 
  }

   public function checkout($data) {
    $total_amount = (int) $data['qty'] * (int) $data['price'];
    $invoice = "INV" . Carbon::now()->format("dmy") . $this->createInvoice();
    return Order::create([
      'product_id'  => $data['product_id'],
      'payment_id'  => $data['payment_id'],
      'item_id'     => $data['item_id'],
      'player_id'   => $data['player_id'],
      'zone_id'     => $data['zone_id'],
      'invoice'     => $invoice, 
      'number_phone' => $data['number_phone'],
      'qty'         => $data['qty'],
      'price'       => (int) $data['price'],
      'before_amount'   => (int) $data['before_amount'],
      'total_amount'    => $total_amount,
      'payment_status'  => PaymentStatusEnum::Pending
    ]);
  }
}