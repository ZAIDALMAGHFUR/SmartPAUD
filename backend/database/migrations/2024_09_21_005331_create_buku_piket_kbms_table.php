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
        Schema::create('bukupiketkbm', function (Blueprint $table) {
            $table->id();
            $table->string('kdprofile')->index()->nullable();
            $table->boolean('statusenabled')->index()->nullable();
            $table->date('tanggal');
            $table->time('kbmdimulaipukul');
            $table->string('keadaancuaca')->nullable();
            $table->integer('jumlahguruseharusnyahadir');
            $table->integer('jumlahguruterlambat');
            $table->integer('jumlahgurutidakhadir');
            $table->integer('jumlahpesertadidikseharusnyahadir');
            $table->integer('jumlahpesertadidikterlambat');
            $table->integer('jumlahpesertadidiktidakhadir');
            $table->text('kejadianpelanggaran')->nullable();
            $table->text('kesimpulanpelaksanaankbm')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukupiketkbm');
    }
};
