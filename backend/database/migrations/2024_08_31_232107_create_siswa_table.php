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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('kdprofile')->index()->nullable();
            $table->boolean('statusenabled')->index()->nullable();
            $table->unsignedBigInteger('users_id')->nullable();
            $table->foreign('users_id')->references('id')->on('users')->nullable();

            // Nama Peserta Didik
            $table->string('namalengkap')->index()->nullable();
            $table->string('namapenggilan')->index()->nullable();
            $table->string('nisn')->index()->unique();
            $table->string('nis')->index()->unique();
            $table->string('nik')->index()->unique();
            $table->string('email')->index()->unique();
            $table->unsignedBigInteger('jeniskelamin_id')->nullable()->index();
            $table->foreign('jeniskelamin_id')->references('id')->on('jeniskelamin')->onDelete('set null')->onUpdate('cascade');
            $table->unsignedBigInteger('statussiswa_id')->nullable()->index();
            $table->foreign('statussiswa_id')->references('id')->on('statussiswa')->onDelete('set null')->onUpdate('cascade');

            //Kelahiran
            $table->unsignedBigInteger('provinsi_id')->nullable();
            $table->foreign('provinsi_id')->references('id')->on('provinsis')->onDelete('cascade');
            $table->unsignedBigInteger('kabupaten_id')->nullable();
            $table->foreign('kabupaten_id')->references('id')->on('kabupatens')->onDelete('cascade');
            $table->unsignedBigInteger('kecamatan_id')->nullable();
            $table->foreign('kecamatan_id')->references('id')->on('kecamatans')->onDelete('cascade');
            $table->unsignedBigInteger('kelurahan_id')->nullable();
            $table->foreign('kelurahan_id')->references('id')->on('kelurahans')->onDelete('cascade');
            $table->string('tempatlahir')->index()->nullable();
            $table->date('tanggallahir')->index()->nullable();
            $table->unsignedBigInteger('agama_id')->nullable()->index();
            $table->foreign('agama_id')->references('id')->on('agama')->onDelete('set null')->onUpdate('cascade');
            $table->unsignedBigInteger('warganegara_id')->nullable()->index();
            $table->foreign('warganegara_id')->references('id')->on('warganegara')->onDelete('set null')->onUpdate('cascade');

            // Jumlah Saudara
            $table->integer('saudarakandung')->index()->nullable();
            $table->integer('saudaratiri')->index()->nullable();
            $table->integer('saudaraangkat')->index()->nullable();
            $table->string('bahasaseharihari')->index()->nullable();

            //kesehatan jasmani
            $table->float('beratbadan')->index()->nullable();
            $table->float('tinggibadan')->index()->nullable();
            $table->unsignedBigInteger('golongandarah_id')->nullable()->index();
            $table->foreign('golongandarah_id')->references('id')->on('golongandarah')->onDelete('set null')->onUpdate('cascade');
            $table->string('penyakitpernahdiderita')->nullable()->index();
            $table->text('alamatrumah')->index()->nullable();
            $table->string('nohandphone')->nullable()->index();
            $table->unsignedBigInteger('statustempattinggal_id')->nullable()->index();
            $table->foreign('statustempattinggal_id')->references('id')->on('statustempattinggal')->onDelete('set null')->onUpdate('cascade');
            $table->string('jaraktempattinggalkesekolah')->nullable()->index();

            //orang tua kandung
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

            //wali murid
            $table->string('namawali')->nullable();
            $table->unsignedBigInteger('pendidikan_wali_id')->nullable()->index();
            $table->foreign('pendidikan_wali_id')->references('id')->on('pendidikan')->onDelete('set null')->onUpdate('cascade');
            $table->unsignedBigInteger('hubunganwali_id')->nullable()->index();
            $table->foreign('hubunganwali_id')->references('id')->on('hubungankeluarga')->onDelete('set null')->onUpdate('cascade');
            $table->unsignedBigInteger('pekerjaan_wali_id')->nullable()->index();
            $table->foreign('pekerjaan_wali_id')->references('id')->on('pekerjaan')->onDelete('set null')->onUpdate('cascade');

            //foto siswa
            $table->string('foto')->index()->nullable();

            //Perkembangan Siswa
            //masuk menjadi peserta didik baru
            $table->string('asalpesertadidik')->index()->nullable();
            $table->string('namalembaga')->index()->nullable();
            $table->string('alamatlembaga')->index()->nullable();

            //pendah dari lembaga lain
            $table->string('namalembagapindah')->index()->nullable();
            $table->string('alamatlembagaasal')->index()->nullable();
            $table->string('daritingkatkelompokumur')->index()->nullable();

            //di terima di lembaga ini
            $table->string('padatanggal')->index()->nullable();
            $table->string('kelompokumur')->index()->nullable();

            //prestasi perseta didik di buat relasi ke table lain

            //kesehatan jasmani Relasi Table

            // Meninggalakan lembaga ini
            //tamat belajar
            $table->unsignedBigInteger('tahunajaran_id')->nullable()->index();
            $table->foreign('tahunajaran_id')->references('id')->on('tahunajaran')->onDelete('set null')->onUpdate('cascade');
            $table->string('notanggalsuratketerangan')->index()->nullable();
            $table->string('melanjutkelembaga')->index()->nullable();

            //pindah lembaga
            $table->string('pindahlembagadarikelompokumur')->index()->nullable();
            $table->string('pindahkelembaga')->index()->nullable();
            $table->string('pindahlembagatingkatkelompokumur')->index()->nullable();
            $table->string('pindahlembagapadatanggal')->index()->nullable();

            //keluar lembaga
            $table->string('keluarlembagapadatanggal')->index()->nullable();
            $table->string('sebabdanalasankeluarlembaga')->index()->nullable();

            //Lain Lain
            $table->string('catatanpenting')->index()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
