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
        Schema::create('ujiansiswa', function (Blueprint $table) {
            $table->id();
            $table->string('kdprofile')->index()->nullable();
            $table->boolean('statusenabled')->index()->nullable();
            $table->foreignId('ujian_id')->constrained('ujian')->onDelete('cascade')->index()->nullable();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->dateTime('started_at')->index()->nullable();
            $table->dateTime('ended_at')->index()->nullable();
            $table->decimal('nilai')->index()->nullable();
            $table->text('user_agent')->index()->nullable();
            $table->text('ip_address')->index()->nullable();
            $table->string('status')->default('0')->index()->nullable();
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
        Schema::dropIfExists('ujiansiswa');
    }
};
