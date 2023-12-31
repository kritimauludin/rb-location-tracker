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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_code', 100)->unique();
            $table->string('newspaper_code', 100);
            $table->string('courier_code', 100)->nullable();
            $table->string('customer_name', 150);
            $table->string('email')->unique();
            $table->string('phone_number', 14);
            $table->date('join_date');
            $table->date('expire_date');
            $table->integer('amount')->default(1);
            $table->text('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
