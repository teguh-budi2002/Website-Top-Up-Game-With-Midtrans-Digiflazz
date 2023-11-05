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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->references('id')->on('role_users')->constrained()->cascadeOnDelete();
            $table->string('fullname');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone_number', 13);
            $table->string('ip_user')->nullable();
            $table->boolean('status_active')->default(true);
            $table->boolean('status_online')->default(false);
            $table->timestamp('last_seen')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
