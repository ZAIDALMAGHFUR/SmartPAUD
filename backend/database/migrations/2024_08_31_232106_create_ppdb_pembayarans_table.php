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
        Schema::create('ppdbpembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('kdprofile')->index()->nullable();
            $table->boolean('statusenabled')->index()->nullable();
            $table->unsignedBigInteger('ppdb_id')->nullable()->index();
            $table->foreign('ppdb_id')->references('id')->on('ppdb')->onDelete('set null');
            $table->unsignedBigInteger('jenispembayaran_id')->nullable()->index();
            $table->foreign('jenispembayaran_id')->references('id')->on('jenispembayaran')->onDelete('set null');
            $table->decimal('jumlah', 15)->nullable();
            $table->datetime('tglbayar')->nullable();
            $table->unsignedBigInteger('statuspembayaran_id')->nullable()->index();
            $table->foreign('statuspembayaran_id')->references('id')->on('statuspembayaran')->onDelete('set null');
            $table->string('keterangan')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppdbpembayaran');
    }
};
