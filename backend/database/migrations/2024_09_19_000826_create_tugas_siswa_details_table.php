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
        Schema::create('tugassiswadetail', function (Blueprint $table) {
            $table->id();
            $table->string('kdprofile')->index()->nullable();
            $table->boolean('statusenabled')->index()->nullable();
            $table->unsignedBigInteger('tugassiswa_id')->nullable()->index();
            $table->foreign('tugassiswa_id')->references('id')->on('tugassiswa');
            $table->string('pertanyaan')->index();
            $table->json('pilihanjawaban')->nullable();
            $table->string('jawabanbenar')->nullable();
            $table->boolean('is_essay')->default(false);
            $table->text('jawaban_essay')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugassiswadetail');
    }
};
