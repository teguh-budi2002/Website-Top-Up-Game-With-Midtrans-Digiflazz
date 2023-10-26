<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function discount() {
        return $this->hasOne(DiscountProduct::class);
    }

    public function product() { 
        return $this->belongsTo(Product::class);
    }
}
