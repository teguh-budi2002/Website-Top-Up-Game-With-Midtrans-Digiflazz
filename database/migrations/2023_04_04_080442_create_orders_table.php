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
            $table->string('invoice');
            $table->string('email');
            $table->integer('number_phone');
            $table->string('player_id');
            $table->string("qty");
            $table->integer("before_amount");
            $table->integer('total_amount');
            $table->enum('payment_status', ['Pending', 'Success', 'Expired']);
            $table->string('snap_token', 36)->nullable();
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
