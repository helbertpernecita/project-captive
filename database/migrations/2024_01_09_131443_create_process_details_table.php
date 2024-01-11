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
        Schema::create('process_details', function (Blueprint $table) {
            $table->id();
            $table->string('check_type')->nullable();
            $table->string('rt_number');
            $table->string('account_number');
            $table->string('account_name');
            $table->string('contcode')->nullable();
            $table->string('form_type');
            $table->string('quantity');
            $table->unsignedBigInteger('process_id');
            $table->foreign('process_id')->references('id')->on('processes')->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('process_details');
    }
};
