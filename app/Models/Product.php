<?php

namespace App\Models;

use App\Models\NominalProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function items() {
      return $this->hasMany(NominalProduct::class);
    }
}
