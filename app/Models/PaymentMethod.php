<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function products() {
        return $this->belongsToMany(Product::class, 'product_payment_method');
    }

    public function fee() {
        return $this->hasOne(PaymentFee::class, 'payment_id');
    }
}
