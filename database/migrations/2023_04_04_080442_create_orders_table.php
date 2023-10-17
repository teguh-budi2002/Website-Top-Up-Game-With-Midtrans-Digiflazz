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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->references('id')->on('products');
            $table->foreignId('item_id')->references('id')->on('items');
            $table->string('invoice');
            $table->string('number_phone', 13)->nullable();
            $table->string('player_id');
            $table->string('zone_id')->nullable();
            $table->string("qty");
            $table->integer('price');
            $table->integer("before_amount");
            $table->integer('total_amount');
            $table->enum('payment_status', ['Pending', 'Success', 'Expired']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
