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
            $table->string('username', 32)->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('first_name', 32);
            $table->string('last_name', 32)->nullable();
            $table->unsignedBigInteger('roles_id');
            $table->foreign('roles_id')->references('id')->on('roles');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_verified')->default(false)->nullable();
            $table->string('verification_token')->nullable();
            $table->string('reset_token')->nullable();
            $table->timestamp('reset_token_expires_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('last_failed_login_at')->nullable();
            $table->unsignedTinyInteger('failed_login_count')->default(0)->nullable();
            $table->string('last_failed_login_ip')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->string('timezone')->nullable();
            $table->string('locale')->nullable();
            $table->string('ip_address')->nullable();
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
