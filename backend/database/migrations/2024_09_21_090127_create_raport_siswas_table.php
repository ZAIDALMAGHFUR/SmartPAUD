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
        Schema::create('raportsiswa', function (Blueprint $table) {
            $table->id();
            $table->string('kdprofile')->nullable()->index(); // Profile Code
            $table->boolean('statusenabled')->nullable()->index(); // Status

            // Foreign keys
            $table->unsignedBigInteger('kelassiswa_id')->nullable();
            $table->foreign('kelassiswa_id')->references('id')->on('kelassiswa')->onDelete('cascade');

            $table->unsignedBigInteger('kelas_id')->nullable();
            $table->foreign('kelas_id')->references('id')->on('kelas');

            $table->unsignedBigInteger('tahunajaran_id')->nullable();
            $table->foreign('tahunajaran_id')->references('id')->on('tahunajaran');

            $table->unsignedBigInteger('guru_id')->nullable();
            $table->foreign('guru_id')->references('id')->on('pegawai');

            $table->unsignedBigInteger('matapelajaran_id')->nullable();
            $table->foreign('matapelajaran_id')->references('id')->on('matapelajaran');

            // Grades and scores
            $table->integer('jumlahkdpengetahuan')->nullable()->index(); // Knowledge score
            $table->integer('nilaipengetahuan')->nullable()->index(); // Knowledge score
            $table->string('predikatpengetahuan')->nullable()->index(); // Knowledge grade
            $table->integer('jumlahkdketerampilan')->nullable()->index(); // Knowledge score
            $table->integer('nilaiketerampilan')->nullable()->index(); // Skills score
            $table->string('predikatketerampilan')->nullable()->index(); // Skills grade
            $table->integer('ratarata')->nullable()->index(); // Average score

            // Additional notes (if necessary)
            $table->text('catatanwalikelas')->nullable();
            $table->text('tanggapanorangtua')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raportsiswa');
    }
};
