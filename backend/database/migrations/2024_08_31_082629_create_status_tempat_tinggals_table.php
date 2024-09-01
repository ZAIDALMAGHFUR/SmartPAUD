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
        Schema::create('statustempattinggal', function (Blueprint $table) {
            $table->id();
            $table->string('kdprofile')->nullable();
            $table->boolean('statusenabled')->nullable();
            $table->string('nama')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statustempattinggal');
    }
};
