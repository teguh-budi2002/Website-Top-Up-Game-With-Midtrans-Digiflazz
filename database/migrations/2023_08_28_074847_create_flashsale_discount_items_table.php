<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flashsale_discount_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flashsale_id')->references('id')->on('flash_sales');
            $table->foreignId('item_id')->references('item_id')->on('discount_products');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flashsale_discount_items');
    }
};
