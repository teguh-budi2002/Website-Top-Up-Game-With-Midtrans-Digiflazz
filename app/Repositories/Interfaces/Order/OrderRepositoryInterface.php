<?php
namespace App\Repositories\Interfaces\Order;

Interface OrderRepositoryInterface{
    public static function checkout($data);
    public static function getSnapToken($order);
}