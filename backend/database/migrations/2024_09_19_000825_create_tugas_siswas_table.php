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
        Schema::create('tugassiswa', function (Blueprint $table) {
            $table->id();
            $table->string('kdprofile')->index()->nullable();
            $table->boolean('statusenabled')->index()->nullable();
            $table->string('name')->index()->nullable();
            $table->enum('type', ['file', 'link'])->index()->nullable();
            $table->string('file_or_link')->index()->nullable();
            $table->text('deskripsi')->index()->nullable();
            $table->dateTime('pengumpulan')->index()->nullable();
            $table->enum('sudahdinilai', ['0', '1'])->index()->nullable();
            $table->unsignedBigInteger('kelas_id')->nullable()->index();
            $table->foreign('kelas_id')->references('id')->on('kelas');
            $table->unsignedBigInteger('tahunajaran_id')->nullable()->index();
            $table->foreign('tahunajaran_id')->references('id')->on('tahunajaran');
            $table->unsignedBigInteger('guru_id')->nullable()->index();
            $table->foreign('guru_id')->references('id')->on('pegawai');
            $table->unsignedBigInteger('matapelajaran_id')->nullable()->index();
            $table->foreign('matapelajaran_id')->references('id')->on('matapelajaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugassiswa');
    }
};
