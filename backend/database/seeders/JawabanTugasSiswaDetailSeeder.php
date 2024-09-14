<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JawabanTugasSiswaDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jawabanTugasSiswaDetail = [
            [
                'kdprofile' => '1',
                'statusenabled' => true,
                'jawabantugassiswa_id' => 1,
                'tugassiswadetail_id' => 1, // ID detail soal "Apa ibukota dari Indonesia?"
                'jawabanpilihan' => 'Jakarta', // Jawaban pilihan ganda yang dipilih siswa
                'jawabanessay' => null, // Tidak ada jawaban esai
                'iscorrect' => true, // Jawaban benar
                'nilai' => 100, // Nilai diberikan karena jawaban benar
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => true,
                'jawabantugassiswa_id' => 1,
                'tugassiswadetail_id' => 2, // ID detail soal "Jelaskan proses siklus air!"
                'jawabanpilihan' => null, // Tidak ada jawaban pilihan ganda
                'jawabanessay' => 'Proses siklus air dimulai dari...', // Jawaban esai siswa
                'iscorrect' => null, // Tidak ada koreksi untuk jawaban esai
                'nilai' => null, // Nilai akan diisi secara manual oleh guru
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => true,
                'jawabantugassiswa_id' => 2,
                'tugassiswadetail_id' => 3, // ID detail soal "Apa warna bendera Indonesia?"
                'jawabanpilihan' => 'Merah Putih', // Jawaban pilihan ganda yang dipilih siswa
                'jawabanessay' => null, // Tidak ada jawaban esai
                'iscorrect' => true, // Jawaban benar
                'nilai' => 100, // Nilai diberikan karena jawaban benar
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => true,
                'jawabantugassiswa_id' => 2,
                'tugassiswadetail_id' => 4, // ID detail soal "Apa pendapatmu tentang pentingnya pendidikan?"
                'jawabanpilihan' => null, // Tidak ada jawaban pilihan ganda
                'jawabanessay' => 'Pendidikan sangat penting karena...', // Jawaban esai siswa
                'iscorrect' => null, // Tidak ada koreksi untuk jawaban esai
                'nilai' => 100, // Nilai akan diisi secara manual oleh guru
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('jawabantugassiswadetail')->insert($jawabanTugasSiswaDetail);
    }
}
