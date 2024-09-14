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
            $table->string('kdprofile');
            $table->boolean('statusenabled');
            $table->unsignedBigInteger('jawabantugassiswa_id')->index();
            $table->foreign('jawabantugassiswa_id')->references('id')->on('jawabantugassiswa')->onDelete('cascade');
            $table->unsignedBigInteger('tugassiswadetail_id')->index();
            $table->foreign('tugassiswadetail_id')->references('id')->on('tugassiswadetail')->onDelete('cascade');
            $table->string('jawabanpilihan')->nullable();
            $table->text('jawabanessay')->nullable();
            $table->boolean('iscorrect')->nullable();
            $table->string('nilai')->nullable();
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
