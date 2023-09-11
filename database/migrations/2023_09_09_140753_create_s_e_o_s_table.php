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
        Schema::create('seo_website', function (Blueprint $table) {
            $table->id();
            $table->string('name_of_the_company', 55)->nullable();
            $table->string('keyword')->nullable();
            $table->string('description')->nullable();
            $table->string('logo_favicon')->nullable();
            $table->string('logo_website')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_e_o_s');
    }
};
