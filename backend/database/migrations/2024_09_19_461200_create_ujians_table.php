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
        Schema::create('ujian', function (Blueprint $table) {
            $table->id();
            $table->string('kdprofile')->index()->nullable();
            $table->boolean('statusenabled')->index()->nullable();
            $table->string('judul')->index()->nullable();
            $table->text('deskripsi')->index()->nullable();
            $table->integer('durasi_ujian')->index()->nullable();
            $table->unsignedBigInteger('tahunajaran_id')->nullable()->index();
            $table->foreign('tahunajaran_id')->references('id')->on('tahunajaran')->onDelete('set null')->onUpdate('cascade');
            $table->enum('tipe_ujian', ['uas','uts','un','us','ujian_praktek','kompetensi','uat'])->nullable();
            $table->enum('tipe_soal', ['essay', 'pilihan_ganda'])->nullable();
            $table->enum('random_soal', ['1', '0'])->nullable();
            $table->enum('lihat_hasil', ['1', '0'])->nullable();
            $table->unsignedBigInteger('jadwalujian_id')->nullable()->index();
            $table->foreign('jadwalujian_id')->references('id')->on('jadwalujian')->onDelete('set null')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujian');
    }
};
