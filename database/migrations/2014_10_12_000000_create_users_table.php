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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_code', 100)->default('waiting');
            $table->string('email', 100)->unique();
            $table->string('name', 150);
            $table->string('phone_number', 14)->default('-');
            $table->text('address')->default('-');
            $table->integer('shipping_handled')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('role_id', false, true)->default(4); //(4, tunggu promote), (1, superadmin), (2, admin), (3, kurir)
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
