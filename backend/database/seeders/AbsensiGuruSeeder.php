<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AbsensiGuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $absens = [
            [
                'kdprofile' => '1',
                'statusenabled' => true,
                'status' => true,
                'rangkuman' => 'Rangkuman 1',
                'beritaacara' => 'Berita Acara 1',
                'kelassiswa_id' => 1,
                'guru_id' => 1,
                'matapelajaran_id' => 1,
                'kelas_id' => 1,
                'tahunajaran_id' => 1,
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => true,
                'status' => true,
                'rangkuman' => 'Rangkuman 2',
                'beritaacara' => 'Berita Acara 2',
                'kelassiswa_id' => 2,
                'guru_id' => 2,
                'matapelajaran_id' => 2,
                'kelas_id' => 2,
                'tahunajaran_id' => 2,
            ]
        ];

        foreach ($absens as $absen) {
            \App\Models\Master\AbsensiGuru::create($absen);
        }
    }
}
