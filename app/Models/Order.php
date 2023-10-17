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
      'payment_status'  => PaymentStatusEnum::class,
      'created_at'      => 'datetime:d F Y | H:i:s',
    ];

    public function product() {
      return $this->belongsTo(Product::class, 'product_id');
    }

    public function item() {
      return $this->belongsTo(Item::class, 'item_id');
    }

    public function payment() {
      return $this->belongsTo(PaymentMethod::class, 'payment_id');
    }
}
