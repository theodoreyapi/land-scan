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
        Schema::create('events_agents', function (Blueprint $table) {
            $table->id('event_agent_id')->primary();
            $table->unsignedBigInteger('agents_id');
            $table->foreign('agents_id')->references('agent_id')->on('agents');
            $table->unsignedBigInteger('events_id')->nullable();
            $table->foreign('events_id')->references('event_id')->on('events');
            $table->unsignedBigInteger('portes_id')->nullable();
            $table->foreign('portes_id')->references('porte_id')->on('portes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events_agents');
        Schema::table('events_agents', function (Blueprint $table) {
            $table->dropForeign(['agents_id', 'events_id']);
            $table->dropColumn('agents_id');
            $table->dropColumn('events_id');
        });
    }
};
