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
        Schema::create('jawabantugassiswa', function (Blueprint $table) {
            $table->id();
            $table->string('kdprofile')->index()->nullable();
            $table->boolean('statusenabled')->index()->nullable();
            $table->unsignedBigInteger('kelassiswa_id')->nullable()->index();
            $table->foreign('kelassiswa_id')->references('id')->on('kelassiswa')->onDelete('cascade')->nullable()->index();
            $table->unsignedBigInteger('tugassiswa_id')->index();
            $table->foreign('tugassiswa_id')->references('id')->on('tugassiswa')->onDelete('cascade');
            $table->unsignedBigInteger('guru_id')->nullable()->index();
            $table->foreign('guru_id')->references('id')->on('pegawai');
            $table->datetime('tgljawab')->index()->nullable();
            $table->string('nilaiakhir')->index()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawabantugassiswa');
    }
};
