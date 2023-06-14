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
        Schema::create('programs_attachment', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('programId')->unsigned();
            $table->foreign('programId')->references('id')->on('programs')->onDelete('cascade');
            $table->string('file_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs_attachment');
    }
};
