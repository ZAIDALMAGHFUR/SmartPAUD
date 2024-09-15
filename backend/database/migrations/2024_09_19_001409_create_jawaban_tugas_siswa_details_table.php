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
        Schema::create('jawabantugassiswadetail', function (Blueprint $table) {
            $table->id();
            $table->string('kdprofile')->index()->nullable();
            $table->boolean('statusenabled')->index()->nullable();
            $table->unsignedBigInteger('jawabantugassiswa_id')->index();
            $table->foreign('jawabantugassiswa_id')->references('id')->on('jawabantugassiswa')->onDelete('cascade');
            $table->unsignedBigInteger('tugassiswadetail_id')->index();
            $table->foreign('tugassiswadetail_id')->references('id')->on('tugassiswadetail')->onDelete('cascade');
            $table->string('jawabanpilihan')->index()->nullable();
            $table->text('jawabanessay')->index()->nullable();
            $table->boolean('iscorrect')->index()->nullable();
            $table->string('nilai')->index()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawabantugassiswadetail');
    }
};
