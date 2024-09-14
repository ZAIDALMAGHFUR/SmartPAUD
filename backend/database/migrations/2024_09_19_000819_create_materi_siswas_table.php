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
        Schema::create('materisiswa', function (Blueprint $table) {
            $table->id();
            $table->string('kdprofile');
            $table->boolean('statusenabled');
            $table->string('name');
            $table->enum('type', ['file', 'link']);
            $table->longText('file_or_link');
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
        Schema::dropIfExists('materisiswa');
    }
};
