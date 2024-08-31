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
        Schema::create('jadwalppdb', function (Blueprint $table) {
            $table->id();
            $table->boolean('statusenabled')->nullable();
            $table->string('kdprofile')->nullable();
            $table->string('nama')->index();
            $table->string('jeniskegiatan')->index();
            $table->date('tglmulai');
            $table->date('tglakhir');
            $table->unsignedBigInteger('tahunajaran_id')->nullable();
            $table->foreign('tahunajaran_id')->references('id')->on('tahunajaran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwalppdb');
    }
};
