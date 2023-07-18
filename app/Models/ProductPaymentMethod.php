<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPaymentMethod extends Model
{
    use HasFactory;
    protected $table = 'product_payment_method';
    protected $guarded = ['id'];
}
