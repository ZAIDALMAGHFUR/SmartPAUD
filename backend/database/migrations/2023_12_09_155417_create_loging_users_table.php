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
        Schema::create('loging_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_id')->nullable();
            $table->foreign('users_id')->references('id')->on('users')->nullable();
            $table->string('ipaddress')->nullable();
            $table->string('browser')->nullable();
            $table->string('activity')->nullable();
            $table->string('url')->nullable();
            $table->string('method')->nullable();
            $table->longText('keterangan')->nullable();
            $table->string('device')->nullable();
            $table->datetime('tgllogin')->nullable();
            $table->time('waktulogin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['users_id']);
        });
        Schema::dropIfExists('loging_users');
    }
};
