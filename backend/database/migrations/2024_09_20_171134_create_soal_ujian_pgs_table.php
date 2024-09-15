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
        Schema::create('soalujianpg', function (Blueprint $table) {
            $table->id();
            $table->string('kdprofile')->index()->nullable();
            $table->boolean('statusenabled')->index()->nullable();
            $table->integer('nomor_soal')->index()->nullable();
            $table->text('pertanyaan')->index()->nullable();
            $table->string('pilihan_a')->index()->nullable();
            $table->string('pilihan_b')->index()->nullable();
            $table->string('pilihan_c')->index()->nullable();
            $table->string('pilihan_d')->index()->nullable();
            $table->string('pilihan_e')->index()->nullable();
            $table->string('jawaban_benar')->index()->nullable();
            $table->foreignId('ujian_id')->constrained('ujian')->onDelete('cascade')->index()->nullable();
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
        Schema::dropIfExists('soalujianpgs');
    }
};
