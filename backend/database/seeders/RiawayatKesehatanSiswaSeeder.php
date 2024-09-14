<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App;
class RiawayatKesehatanSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        App\Models\Master\RiawayatKesehatanSiswa::create([
            'kdprofile' => '1',
            'statusenabled' => true,
            'siswa_id' => 1,
            'penyakit' => 'Asma',
            'riwayatpengobatan' => 'Pengobatan Rutin',
            'alergi' => 'Debu',
            'catatankesehatanlainnya' => 'Perlu cek kesehatan rutin',
        ]);

        App\Models\Master\RiawayatKesehatanSiswa::create([
            'kdprofile' => '1',
            'statusenabled' => true,
            'siswa_id' => 2,
            'penyakit' => 'Diabetes',
            'riwayatpengobatan' => 'Injeksi Insulin',
            'alergi' => 'Seafood',
            'catatankesehatanlainnya' => 'Perlu diet khusus',
        ]);
    }
}
