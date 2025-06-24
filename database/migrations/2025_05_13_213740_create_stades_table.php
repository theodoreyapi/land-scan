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
        Schema::create('stades', function (Blueprint $table) {
            $table->id('stade_id')->primary();
            $table->string('stade_image')->nullable();
            $table->string('stade_name');
            $table->string('stade_address')->nullable();
            $table->string('stade_status')->comment('Active, Inactive')->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stades');
    }
};
