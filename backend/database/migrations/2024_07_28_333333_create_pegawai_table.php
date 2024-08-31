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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('kdprofile')->nullable();
            $table->boolean('statusenabled')->nullable();
            $table->unsignedBigInteger('users_id')->nullable();
            $table->foreign('users_id')->references('id')->on('users')->nullable();
            $table->unsignedBigInteger('agama_id')->nullable();
            $table->foreign('agama_id')->references('id')->on('agama')->nullable();
            $table->unsignedBigInteger('jeniskelamin_id')->nullable();
            $table->foreign('jeniskelamin_id')->references('id')->on('jeniskelamin')->nullable();
            $table->unsignedBigInteger('golongandarah_id')->nullable();
            $table->foreign('golongandarah_id')->references('id')->on('golongandarah')->nullable();
            $table->unsignedBigInteger('pekerjaan_id')->nullable();
            $table->foreign('pekerjaan_id')->references('id')->on('pekerjaan')->nullable();
            $table->unsignedBigInteger('pendidikan_id')->nullable();
            $table->foreign('pendidikan_id')->references('id')->on('pendidikan')->nullable();
            $table->unsignedBigInteger('statusperkawinan_id')->nullable();
            $table->foreign('statusperkawinan_id')->references('id')->on('statusperkawinan')->nullable();
            $table->unsignedBigInteger('warganegara_id')->nullable();
            $table->foreign('warganegara_id')->references('id')->on('warganegara')->nullable();
            $table->string('namalengkap')->nullable();
            $table->string('nik')->nullable();
            $table->string('npwp')->nullable();
            $table->string('nohp')->nullable();
            $table->string('email')->nullable();
            $table->string('nobpjs')->nullable();
            $table->string('nopaspor')->nullable();
            $table->string('nokk')->nullable();
            $table->string('noasuransilain')->nullable();
            $table->string('nip')->nullable();
            $table->string('nosip')->nullable();
            $table->string('nostr')->nullable();
            $table->datetime('tglberakhirsip')->nullable();
            $table->datetime('tglberakhirstr')->nullable();
            $table->datetime('tglterbitsip')->nullable();
            $table->datetime('tglterbitstr')->nullable();
            $table->integer('kddokterbpjs')->nullable();
            $table->boolean('isdpjp')->nullable();
            $table->datetime('tgllahir')->nullable();
            $table->unsignedBigInteger('provinsi_id')->onDelete('cascade')->nullable();
            $table->foreign('provinsi_id')->references('id')->on('provinsis')->nullable();
            $table->unsignedBigInteger('kabupaten_id')->onDelete('cascade')->nullable();
            $table->foreign('kabupaten_id')->references('id')->on('kabupatens')->nullable();
            $table->unsignedBigInteger('kecamatan_id')->onDelete('cascade')->nullable();
            $table->foreign('kecamatan_id')->references('id')->on('kecamatans')->nullable();
            $table->unsignedBigInteger('kelurahan_id')->onDelete('cascade')->nullable();
            $table->foreign('kelurahan_id')->references('id')->on('kelurahans')->nullable();
            $table->string('kodepos')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->unsignedBigInteger('jabatan_id')->nullable();
            $table->foreign('jabatan_id')->references('id')->on('jabatan')->nullable();
            $table->unsignedBigInteger('jenispegawai_id')->nullable();
            $table->foreign('jenispegawai_id')->references('id')->on('jenispegawai')->nullable();
            $table->unsignedBigInteger('golonganpegawai_id')->nullable();
            $table->foreign('golonganpegawai_id')->references('id')->on('golonganpegawai')->nullable();
            $table->unsignedBigInteger('unitkerja_id')->nullable();
            $table->foreign('unitkerja_id')->references('id')->on('unitkerja')->nullable();
            $table->unsignedBigInteger('kategorypegawai_id')->nullable();
            $table->foreign('kategorypegawai_id')->references('id')->on('kategorypegawai')->nullable();
            $table->unsignedBigInteger('statuspegawai_id')->nullable();
            $table->foreign('statuspegawai_id')->references('id')->on('statuspegawai')->nullable();
            $table->unsignedBigInteger('kelompokpegawai_id')->nullable();
            $table->foreign('kelompokpegawai_id')->references('id')->on('kelompokpegawai')->nullable();
            $table->unsignedBigInteger('shiftkerja_id')->nullable();
            $table->foreign('shiftkerja_id')->references('id')->on('shiftkerja')->nullable();
            $table->string('namabank')->nullable();
            $table->string('norekening')->nullable();
            $table->string('namarekening')->nullable();
            $table->string('namakeluarga')->nullable();
            $table->string('fingerprintid')->nullable();
            $table->datetime('tgldaftarfingerprint')->nullable();
            $table->datetime('tglmasuk')->nullable();
            $table->datetime('tglkeluar')->nullable();
            $table->string('ihs_id')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
