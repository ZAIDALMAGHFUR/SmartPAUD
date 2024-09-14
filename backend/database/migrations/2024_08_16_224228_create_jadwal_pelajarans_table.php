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
        Schema::create('jadwalpelajaran', function (Blueprint $table) {
            $table->id();
            $table->string('kdprofile');
            $table->boolean('statusenabled');
            $table->enum('jenis_kegiatan', ['Pelajaran', 'Istirahat', 'Upacara', 'Literasi', 'IMTAQ', 'Jumatan'])->default('Pelajaran')->index();
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'])->index();
            $table->time('jam_mulai')->index();
            $table->time('jam_selesai')->index();
            $table->unsignedBigInteger('kelas_id')->nullable()->index();
            $table->foreign('kelas_id')->references('id')->on('kelas')->nullable();
            $table->unsignedBigInteger('matapelajaran_id')->nullable()->index();
            $table->foreign('matapelajaran_id')->references('id')->on('matapelajaran')->nullable();
            $table->unsignedBigInteger('guru_id')->nullable();
            $table->foreign('guru_id')->references('id')->on('pegawai')->nullable();
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
        Schema::dropIfExists('jadwalpelajaran');
    }
};
