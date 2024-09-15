<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Master\Ujian;

class UjianSeeder extends Seeder
{
    public function run()
    {
        Ujian::create([
            'kdprofile' => '1',
            'statusenabled' => true,
            'judul' => 'Ujian Akhir Semester 1',
            'deskripsi' => 'Ujian untuk semester ganjil',
            'durasi_ujian' => 90,
            'tahunajaran_id' => 1,
            'tipe_ujian' => 'uas',
            'tipe_soal' => 'pilihan_ganda',
            'random_soal' => '1',
            'lihat_hasil' => '0',
            'jadwalujian_id' => 1,
        ]);

        Ujian::create([
            'kdprofile' => '1',
            'statusenabled' => true,
            'judul' => 'Ujian Tengah Semester 1',
            'deskripsi' => 'Ujian untuk evaluasi di tengah semester',
            'durasi_ujian' => 60,
            'tahunajaran_id' => 2,
            'tipe_ujian' => 'uts',
            'tipe_soal' => 'essay',
            'random_soal' => '0',
            'lihat_hasil' => '1',
            'jadwalujian_id' => 2,
        ]);

        Ujian::create([
            'kdprofile' => '1',
            'statusenabled' => false,
            'judul' => 'Ujian Akhir Semester 2',
            'deskripsi' => 'Ujian untuk semester genap',
            'durasi_ujian' => 120,
            'tahunajaran_id' => 3,
            'tipe_ujian' => 'uas',
            'tipe_soal' => 'pilihan_ganda',
            'random_soal' => '1',
            'lihat_hasil' => '0',
            'jadwalujian_id' => 3,
        ]);
    }
}
