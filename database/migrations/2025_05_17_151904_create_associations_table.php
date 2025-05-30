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
        Schema::create('associations', function (Blueprint $table) {
            $table->id('association_id');
            $table->unsignedBigInteger('tickets_id')->nullable();
            $table->foreign('tickets_id')->references('ticket_id')->on('tickets');
            $table->unsignedBigInteger('agence_id')->nullable();
            $table->foreign('agence_id')->references('agent_id')->on('agents');
            $table->unsignedBigInteger('port_id')->nullable();
            $table->foreign('port_id')->references('porte_id')->on('portes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associations');
        Schema::table('associations', function (Blueprint $table) {
            $table->dropForeign(['tickets_id','agence_id','port_id']);
            $table->dropColumn('tickets_id');
            $table->dropColumn('agence_id');
            $table->dropColumn('port_id');
        });
    }
};
