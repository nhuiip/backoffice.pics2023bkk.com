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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->integer('seq');
            $table->string('name');
            $table->string('description')->nullable();
            $table->longText('content')->nullable();
            $table->longText('content_journey')->nullable();
            $table->string('tel')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->integer('ranging')->nullable();
            $table->decimal('priceSingle')->nullable();
            $table->decimal('priceDouble')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
