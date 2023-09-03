<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function items_flashsale() {
        return $this->belongsToMany( DiscountProduct::class, 'flashsale_discount_items', 'flashsale_id', 'item_id');
    }
}
