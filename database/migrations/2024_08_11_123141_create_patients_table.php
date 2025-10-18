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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('age');
            $table->string('gender');
            $table->string('source');
            $table->unsignedBigInteger('doctor')->nullable(); // Foreign key column
            $table->foreign('doctor')->references('id')->on('doctors');
            $table->string('medical_history')->nullable();
            $table->string('appointment_date');
            $table->string('appointment_time');
            $table->string('services');
            $table->string('coupon')->nullable();
            $table->string('discount')->default(0);
            $table->string('amount')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_date')->nullable();
            $table->string('receipt_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
