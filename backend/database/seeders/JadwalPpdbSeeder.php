<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalPpdb;
use Carbon\Carbon;

class JadwalPpdbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jadwalPpdbs = [
            [
                'statusenabled' => true,
                'kdprofile' => 'PROF001',
                'nama' => 'Pendaftaran Gelombang 1',
                'jeniskegiatan' => 'Pendaftaran',
                'tglmulai' => Carbon::create(2024, 1, 1),
                'tglakhir' => Carbon::create(2024, 1, 31),
                'tahunajaran_id' => 1,
            ],
            [
                'statusenabled' => true,
                'kdprofile' => 'PROF002',
                'nama' => 'Pendaftaran Gelombang 2',
                'jeniskegiatan' => 'Pendaftaran',
                'tglmulai' => Carbon::create(2024, 2, 1),
                'tglakhir' => Carbon::create(2024, 2, 28),
                'tahunajaran_id' => 2,
            ],
            [
                'statusenabled' => true,
                'kdprofile' => 'PROF003',
                'nama' => 'Tes Seleksi',
                'jeniskegiatan' => 'Seleksi',
                'tglmulai' => Carbon::create(2024, 3, 1),
                'tglakhir' => Carbon::create(2024, 3, 7),
                'tahunajaran_id' => 3,
            ],
            [
                'statusenabled' => true,
                'kdprofile' => 'PROF004',
                'nama' => 'Pengumuman Hasil Seleksi',
                'jeniskegiatan' => 'Pengumuman',
                'tglmulai' => Carbon::create(2024, 3, 10),
                'tglakhir' => Carbon::create(2024, 3, 10),
                'tahunajaran_id' => 4,
            ],
        ];

        foreach ($jadwalPpdbs as $jadwal) {
            \App\Models\Master\JadwalPpdb::create($jadwal);
        }
    }
}
