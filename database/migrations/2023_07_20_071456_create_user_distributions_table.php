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
        Schema::create('user_distributions', function (Blueprint $table) {
            $table->id();
            $table->string('distribution_code');
            $table->string('customer_code');
            $table->integer('total')->default(1);
            $table->timestamp('received_date')->nullable();
            $table->integer('status')->default(201); // 200 = terkirim, 201 = menunggu, 202 = diperjalanan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_distributions');
    }
};
