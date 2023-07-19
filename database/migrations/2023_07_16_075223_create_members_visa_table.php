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
        Schema::create('members_visa', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('memberId')->unsigned();
            $table->foreign('memberId')->references('id')->on('members')->onDelete('cascade');
            $table->string('nationality')->nullable();
            $table->string('gender')->nullable();
            $table->string('identification_number')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('passport_expiry_date')->nullable();
            $table->string('passport_issue_date')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members_visa');
    }
};
