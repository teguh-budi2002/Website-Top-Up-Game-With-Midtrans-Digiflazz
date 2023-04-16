<?php
namespace App\Repositories\Interfaces\Order;

Interface OrderRepositoryInterface{
    public function checkout($data);
    public function getSnapToken($order);
}