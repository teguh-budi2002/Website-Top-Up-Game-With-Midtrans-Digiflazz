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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string("trx_id");
            $table->string('invoice');
            $table->string("payment_type_trx", 20);
            $table->dateTime("transaction_time");
            $table->dateTime("transaction_expired");
            $table->string("transaction_payment_status", 11);
            $table->string("transaction_order_status", 11);
            $table->string("gross_amount", 20);
            $table->string("qr_code_url")->nullable();
            $table->string("va_number")->nullable();
            $table->string("bank_name", 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
