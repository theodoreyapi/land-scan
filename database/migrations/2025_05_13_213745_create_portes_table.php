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
        Schema::create('portes', function (Blueprint $table) {
            $table->id('porte_id');
            $table->string('porte_name');
            $table->string('porte_status')->comment('Active, Inactive')->default('Active');
            $table->unsignedBigInteger('stades_id');
            $table->foreign('stades_id')->references('stade_id')->on('stades')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portes');
        Schema::table('portes', function (Blueprint $table) {
            $table->dropForeign(['stades_id']);
            $table->dropColumn('stades_id');
        });
    }
};
