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
        Schema::create('shiftkerja', function (Blueprint $table) {
            $table->id();
            $table->string('kdprofile')->nullable();
            $table->boolean('statusenabled')->nullable();
            $table->string('name')->nullable();
            $table->time('jammasuk')->nullable();
            $table->time('jampulang')->nullable();
            $table->time('jambreakakhir')->nullable();
            $table->time('jambreakawal')->nullable();
            $table->integer('factorrate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shiftkerja');
    }
};
