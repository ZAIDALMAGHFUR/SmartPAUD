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
        Schema::create('ppdb', function (Blueprint $table) {
            $table->id();
            $table->boolean('statusenabled')->nullable();
            $table->string('kdprofile')->nullable();
            $table->unsignedBigInteger('users_id')->nullable();
            $table->foreign('users_id')->references('id')->on('users')->nullable();
            $table->string('namalengkap')->index();  // Index for commonly searched columns
            $table->string('namapanggilan')->index();
            $table->unsignedBigInteger('jeniskelamin_id')->nullable()->index();
            $table->foreign('jeniskelamin_id')->references('id')->on('jeniskelamin')->onDelete('set null')->onUpdate('cascade');
            $table->date('tanggallahir')->index();
            $table->string('tempatlahir');
            $table->unsignedBigInteger('agama_id')->nullable()->index();
            $table->foreign('agama_id')->references('id')->on('agama')->onDelete('set null')->onUpdate('cascade');
            $table->unsignedBigInteger('warganegara_id')->nullable()->index();
            $table->foreign('warganegara_id')->references('id')->on('warganegara')->onDelete('set null')->onUpdate('cascade');
            $table->integer('anaknomorke')->index();
            $table->integer('jumlahsaudarakandung');
            $table->integer('jumlahsaudaratiri')->nullable();
            $table->integer('jumlahsaudaraangkat')->nullable();
            $table->string('bahasaseharihari');
            $table->float('beratbadan');
            $table->float('tinggibadan');
            $table->unsignedBigInteger('golongandarah_id')->nullable()->index();
            $table->foreign('golongandarah_id')->references('id')->on('golongandarah')->onDelete('set null')->onUpdate('cascade');
            $table->string('penyakitpernahdiderita')->nullable();
            $table->text('alamattempattinggal');
            $table->string('nomortelepon')->nullable();
            $table->unsignedBigInteger('statustempattinggal_id')->nullable()->index();
            $table->foreign('statustempattinggal_id')->references('id')->on('statustempattinggal')->onDelete('set null')->onUpdate('cascade');

            // Parent or guardian information
            $table->string('namaayah')->nullable();
            $table->string('namaibu')->nullable();
            $table->unsignedBigInteger('pendidikan_ayah_id')->nullable()->index();
            $table->foreign('pendidikan_ayah_id')->references('id')->on('pendidikan')->onDelete('set null')->onUpdate('cascade');
            $table->unsignedBigInteger('pendidikan_ibu_id')->nullable()->index();
            $table->foreign('pendidikan_ibu_id')->references('id')->on('pendidikan')->onDelete('set null')->onUpdate('cascade');
            $table->unsignedBigInteger('pekerjaan_ayah_id')->nullable()->index();
            $table->foreign('pekerjaan_ayah_id')->references('id')->on('pekerjaan')->onDelete('set null')->onUpdate('cascade');
            $table->unsignedBigInteger('pekerjaan_ibu_id')->nullable()->index();
            $table->foreign('pekerjaan_ibu_id')->references('id')->on('pekerjaan')->onDelete('set null')->onUpdate('cascade');
            $table->string('namawali')->nullable();
            $table->unsignedBigInteger('pendidikan_wali_id')->nullable()->index();
            $table->foreign('pendidikan_wali_id')->references('id')->on('pendidikan')->onDelete('set null')->onUpdate('cascade');
            $table->unsignedBigInteger('hubunganwali_id')->nullable()->index();
            $table->foreign('hubunganwali_id')->references('id')->on('hubungankeluarga')->onDelete('set null')->onUpdate('cascade');
            $table->unsignedBigInteger('pekerjaan_wali_id')->nullable()->index();
            $table->foreign('pekerjaan_wali_id')->references('id')->on('pekerjaan')->onDelete('set null')->onUpdate('cascade');

            // School history
            $table->unsignedBigInteger('statusmasuk_id')->nullable()->index();
            $table->foreign('statusmasuk_id')->references('id')->on('statusmasuk')->onDelete('set null')->onUpdate('cascade');
            $table->string('namatkasal')->nullable();
            $table->date('tanggalpindahan')->nullable();
            $table->string('kelompokpindahan')->nullable();
            $table->date('tanggalditerima')->nullable();
            $table->string('kelompokditerima')->nullable();
            $table->unsignedBigInteger('statuspendaftaran_id')->nullable()->index();
            $table->foreign('statuspendaftaran_id')->references('id')->on('statuspendaftaran')->onDelete('set null')->onUpdate('cascade');
            $table->string('alasanpenolakan')->nullable();
            $table->string('nopendaftaran')->index();

            //personal info
            $table->string('nohandphone')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppdb');
    }
};
