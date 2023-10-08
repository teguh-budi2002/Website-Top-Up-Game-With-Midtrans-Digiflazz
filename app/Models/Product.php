<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function category() {
      return $this->belongsTo(CategoryProduct::class);
    }

    public function items() {
      return $this->hasMany(Item::class);
    }

    public function paymentMethods() {
      return $this->belongsToMany(PaymentMethod::class, 'product_payment_method');
    }

}
