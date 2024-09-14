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
        Schema::create('prestasisiswa', function (Blueprint $table) {
            $table->id();
            $table->string('kdprofile')->index()->nullable();
            $table->boolean('statusenabled')->index()->nullable();
            $table->unsignedBigInteger('siswa_id')->nullable();
            $table->foreign('siswa_id')->references('id')->on('siswa')->nullable();
            $table->enum('jenisprestasi', ['Akademik', 'Olahraga', 'Seni', 'Teknologi', 'Lainnya'])->index();
            $table->string('namaprestasi')->index();
            $table->string('tingkatprestasi')->index();
            $table->enum('peringkat', ['Juara 1', 'Juara 2', 'Juara 3', 'Finalis', 'Partisipasi'])->nullable();
            $table->string('penyelenggara')->nullable();
            $table->date('tanggalprestasi')->nullable();
            $table->string('dokumenprestasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestasisiswa');
    }
};
