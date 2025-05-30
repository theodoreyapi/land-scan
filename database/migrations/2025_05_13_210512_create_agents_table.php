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
        Schema::create('agents', function (Blueprint $table) {
            $table->id('agent_id');
            $table->string('agent_photo')->nullable();
            $table->string('agent_name');
            $table->string('agent_email')->nullable()->unique();
            $table->string('agent_phone')->unique();
            $table->string('agent_password');
            $table->string('agent_status')->comment('Active, Inactive')->default('Active');
            $table->boolean('agent_connected')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
