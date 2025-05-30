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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id('ticket_id');
            $table->string('ticket_code')->unique();
            $table->string('ticket_st');
            $table->string('ticket_free');
            $table->string('ticket_seas')->nullable();
            $table->string('ticket_passed')->nullable();
            $table->string('ticket_status')->comment('Active, Inactive')->default('Active');
            $table->unsignedBigInteger('evenment_id')->nullable();
            $table->foreign('evenment_id')->references('event_id')->on('events');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['evenment_id']);
            $table->dropColumn('evenment_id');
        });
    }
};
