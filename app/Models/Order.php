<?php

namespace App\Models;

use App\Models\Product;
use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
      'payment_status' => PaymentStatusEnum::class
    ];

    public function product() {
      return $this->belongsTo(Product::class);
    }

    // public function brand() {
    //   return $this->belongsTo(Brand::class);
    // }
}
