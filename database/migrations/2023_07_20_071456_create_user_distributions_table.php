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
            $table->string('distribution_code', 100);
            $table->string('customer_code', 100);
            $table->integer('total')->default(1);
            $table->timestamp('process_at')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->integer('status')->default(202); // 200 = terkirim, 201 = diperjalanan , 202 = menunggu
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
