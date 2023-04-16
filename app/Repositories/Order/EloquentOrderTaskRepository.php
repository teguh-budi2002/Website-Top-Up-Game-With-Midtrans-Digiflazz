<?php
namespace App\Repositories\Order;

use App\Models\Order;
use App\Repositories\Interfaces\Order\EloquentOrderRepositoryInterface;

class EloquentOrderTaskRepository implements EloquentOrderRepositoryInterface {

  public function getAllOrder() {
    return Order::get();
  }

  public function getAllOrderWithProduct() {
    return Order::with('product')->get();
  }

  public function getOrderById($orderId) {
    return Order::whereId($orderId)->first();
  }

  public function getOrderWithProduct($orderId) {
    return Order::with('product')->whereId($orderId)->first();
  }
}