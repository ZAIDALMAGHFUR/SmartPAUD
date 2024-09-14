<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TugasSiswaDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tugassiswadetail')->insert([
            [
                'kdprofile' => '1',
                'statusenabled' => true,
                'tugassiswa_id' => 1, // Sesuaikan dengan ID tugas yang valid
                'pertanyaan' => 'Apa ibukota dari Indonesia?',
                'pilihanjawaban' => json_encode([
                    'Jakarta',
                    'Surabaya',
                    'Bandung',
                    'Medan'
                ]),
                'jawabanbenar' => 'Jakarta',
                'is_essay' => false,
                'jawaban_essay' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => true,
                'tugassiswa_id' => 1, // Sesuaikan dengan ID tugas yang valid
                'pertanyaan' => 'Jelaskan proses siklus air!',
                'pilihanjawaban' => null, // Soal ini tidak memiliki pilihan ganda
                'jawabanbenar' => null,
                'is_essay' => true,
                'jawaban_essay' => null, // Akan diisi oleh siswa
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => true,
                'tugassiswa_id' => 2, // Sesuaikan dengan ID tugas yang valid
                'pertanyaan' => 'Apa warna bendera Indonesia?',
                'pilihanjawaban' => json_encode([
                    'Merah Putih',
                    'Biru Putih',
                    'Hijau Kuning',
                    'Merah Biru'
                ]),
                'jawabanbenar' => 'Merah Putih',
                'is_essay' => false,
                'jawaban_essay' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => true,
                'tugassiswa_id' => 2, // Sesuaikan dengan ID tugas yang valid
                'pertanyaan' => 'Apa pendapatmu tentang pentingnya pendidikan?',
                'pilihanjawaban' => null, // Soal ini tidak memiliki pilihan ganda
                'jawabanbenar' => null,
                'is_essay' => true,
                'jawaban_essay' => null, // Akan diisi oleh siswa
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
