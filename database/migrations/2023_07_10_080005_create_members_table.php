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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('email');
            $table->string('email_secondary')->nullable();
            $table->string('password');
            $table->string('password_raw');
            $table->string('title');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('address');
            $table->string('city');
            $table->string('city_code');
            $table->string('country');
            $table->string('phone')->nullable();
            $table->string('phone_mobile');
            $table->string('organization');
            $table->string('profession_title');
            $table->string('registration_type');
            $table->string('registrant_group');
            $table->string('tax_id');
            $table->string('tax_phone');
            $table->string('dietary_restrictions')->nullable();
            $table->string('special_requirements')->nullable();
            $table->boolean('isConsentPdpa')->default(true);
            $table->boolean('isConsentCondition')->default(true);
            $table->string('total');
            $table->integer('payment_method')->comment('1: Credit Card, 2: Bank Transfer')->default(2);
            $table->integer('payment_status')->comment('1: Pending, 2: Paid, 3: Cancelled, 4: Void, 5: Refund')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
