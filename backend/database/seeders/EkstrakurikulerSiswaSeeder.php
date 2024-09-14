<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EkstrakurikulerSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ekstrakurikulerSiswa = [
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'kelassiswa_id' => 1,
                'guru_id' => 1,
                'tglmasuk' => '2024-08-18 15:03:11',
                'tglkeluar' => '2024-08-18 15:03:11',
                'keterangan' => 'Lorem ipsum dolor sit amet',
                'ekstrakurikuler_id' => 1,
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'kelassiswa_id' => 2,
                'guru_id' => 2,
                'tglmasuk' => '2024-08-18 15:03:11',
                'tglkeluar' => '2024-08-18 15:03:11',
                'keterangan' => 'Lorem ipsum dolor sit amet',
                'ekstrakurikuler_id' => 2,
            ],
        ];

        foreach ($ekstrakurikulerSiswa as $data) {
            \App\Models\Master\EkstrakurikulerSiswa::create($data);
        }
    }
}
