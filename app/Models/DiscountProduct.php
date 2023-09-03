<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountProduct extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function item() {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function flashsales() {
        return $this->belongsToMany(FlashSale::class, 'flashsale_discount_items', 'flashsale_id', 'item_id');
    }
}
