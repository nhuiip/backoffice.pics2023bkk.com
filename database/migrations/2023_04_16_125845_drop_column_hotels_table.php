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
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn('content_journey');
            $table->dropColumn('priceSingle');
            $table->dropColumn('priceDouble');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
