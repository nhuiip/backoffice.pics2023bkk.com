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
        Schema::create('payment_transaction', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('memberId')->unsigned();
            $table->foreign('memberId')->references('id')->on('members')->onDelete('cascade');
            $table->integer('transaction_id');
            $table->string('payment_url');
            $table->decimal('amount', 8, 2);
            $table->string('paylink_token');
            $table->dateTime('startDate');
            $table->dateTime('expiredDate');
            $table->boolean('isExpired')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transaction');
    }
};
