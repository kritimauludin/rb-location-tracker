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
            $table->string('user_code')->default('waiting');
            $table->string('email')->unique();
            $table->string('name');
            $table->string('phone_number', 14)->default('-');
            $table->text('address')->default('-');
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
