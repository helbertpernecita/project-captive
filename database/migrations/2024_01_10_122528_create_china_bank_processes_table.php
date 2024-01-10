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
        Schema::create('china_bank_processes', function (Blueprint $table) {
            $table->id();
            $table->string('check_type');
            $table->string('rt_number');
            $table->string('account_number');
            $table->string('account_name');
            $table->string('contcode')->nullable();
            $table->string('form_type');
            $table->string('quantity');
            $table->boolean('isProcessed');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('china_bank_processes');
    }
};
