<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ujiansiswahasil', function (Blueprint $table) {
            $table->id();
            $table->string('kdprofile')->index()->nullable();
            $table->boolean('statusenabled')->index()->nullable();
            $table->foreignId('ujiansiswa_id')->constrained('ujiansiswa')->onDelete('cascade');
            $table->unsignedBigInteger('soalujianpg_id')->nullable();
            $table->unsignedBigInteger('soalujianessay_id')->nullable();
            $table->string('jawaban')->index()->nullable();
            $table->string('ragu')->index()->nullable();
            $table->string('status')->index()->nullable();
            $table->foreignId('guru_id')->nullable()->constrained('pegawai')->onDelete('cascade')->index()->nullable();
            $table->text('komentar_guru')->index()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ujiansiswahasil');
    }
};
