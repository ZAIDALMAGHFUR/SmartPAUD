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
        Schema::create('kelassiswa', function (Blueprint $table) {
            $table->id();
            $table->string('kdprofile')->index()->nullable();
            $table->boolean('statusenabled')->index()->nullable();
            $table->unsignedBigInteger('siswa_id')->nullable();
            $table->foreign('siswa_id')->references('id')->on('siswa')->nullable();
            $table->unsignedBigInteger('tahunajaran_id')->nullable()->index();
            $table->foreign('tahunajaran_id')->references('id')->on('tahunajaran')->onDelete('set null')->onUpdate('cascade');
            $table->unsignedBigInteger('kelas_id')->nullable()->index();
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('set null')->onUpdate('cascade');
            $table->unsignedBigInteger('walikelas_id')->nullable()->index();
            $table->foreign('walikelas_id')->references('id')->on('pegawai')->onDelete('set null')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelassiswa');
    }
};
