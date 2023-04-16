<?php
namespace App\Repositories\Interfaces\Order;

Interface EloquentOrderRepositoryInterface{
    public function getAllOrder();
    public function getAllOrderWithProduct();
    public function getOrderById($orderId);
    public function getOrderWithProduct($orderId);
}