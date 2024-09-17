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
        Schema::create('kehadiranguru', function (Blueprint $table) {
            $table->id();
            $table->string('kdprofile')->index()->nullable();
            $table->boolean('statusenabled')->index()->nullable();
            $table->unsignedBigInteger('guru_id')->nullable()->index();
            $table->foreign('guru_id')->references('id')->on('pegawai');
            $table->unsignedBigInteger('matapelajaran_id')->nullable()->index();
            $table->foreign('matapelajaran_id')->references('id')->on('matapelajaran');
            $table->string('keterangan')->nullable();
            $table->foreignId('bukupiketkbm_id')->constrained('bukupiketkbm')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kehadiranguru');
    }
};
