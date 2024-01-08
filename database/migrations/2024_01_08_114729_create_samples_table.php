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
        Schema::create('samples', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('check_type')->nullable();
            $table->string('check_name')->nullable();
            $table->string('brstn')->nullable();
            $table->string('acccount_number')->nullable();
            $table->string('name1')->nullable();
            $table->string('name2')->nullable();
            $table->string('name3')->nullable();
            $table->string('name4')->nullable();
            $table->string('starting_serial')->nullable();
            $table->string('ending_serial')->nullable();
            $table->string('batch')->nullable();
            $table->string('final_batch')->nullable();
            $table->string('branch_code')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('address3')->nullable();
            $table->string('address4')->nullable();
            $table->string('address5')->nullable();
            $table->string('address6')->nullable();
            $table->string('hash_sent_date')->nullable();
            $table->string('hash_sent_time')->nullable();
            $table->longText('packing_blob')->nullable();
            $table->string('file_name')->nullable();
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
        Schema::dropIfExists('samples');
    }
};
