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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('sp_id')->nullable();
            $table->text('clinic_name')->nullable();
            $table->text('clinic_location')->nullable();
            $table->integer('gpay_number')->nullable();
            $table->text('upi')->nullable();
            $table->unsignedBigInteger('representative_id'); // Foreign key column
            $table->foreign('representative_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('meeting_purpose')->nullable();
            $table->text('feedback')->nullable();
            $table->string('status')->nullable();
            $table->string('konark_team')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
