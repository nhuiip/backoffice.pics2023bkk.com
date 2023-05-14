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
        Schema::create('registration_free', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('registrationRateId')->unsigned();
            $table->foreign('registrationRateId')->references('id')->on('registration_rate')->onDelete('cascade');
            $table->bigInteger('registrantTypeId')->unsigned();
            $table->foreign('registrantTypeId')->references('id')->on('registrant_type')->onDelete('cascade');
            $table->bigInteger('registrantGroupId')->unsigned();
            $table->foreign('registrantGroupId')->references('id')->on('registrant_group')->onDelete('cascade');
            $table->decimal('price');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_free');
    }
};
