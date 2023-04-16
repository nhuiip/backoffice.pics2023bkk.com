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
        Schema::create('pricing_mapping', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pricingId')->unsigned();
            $table->foreign('pricingId')->references('id')->on('pricing')->onDelete('cascade');
            $table->bigInteger('sessionId')->unsigned();
            $table->foreign('sessionId')->references('id')->on('sessions')->onDelete('cascade');
            $table->decimal('price');
            $table->boolean('invited')->default(false);
            $table->integer('invited_person')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_mapping');
    }
};
