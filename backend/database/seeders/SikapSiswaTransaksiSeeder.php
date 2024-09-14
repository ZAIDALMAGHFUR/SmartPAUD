<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SikapSiswaTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sikapSiswaTransaksi = [
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'kelassiswa_id' => 1,
                'guru_id' => 1,
                'tglmasuk' => '2024-08-18 22:36:00',
                'tglkeluar' => '2024-08-18 22:36:00',
                'keterangan' => 'Lorem ipsum dolor sit amet',
                'sikapsiswa_id' => 1,
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'kelassiswa_id' => 2,
                'guru_id' => 2,
                'tglmasuk' => '2024-08-18 22:36:00',
                'tglkeluar' => '2024-08-18 22:36:00',
                'keterangan' => 'Lorem ipsum dolor sit amet',
                'sikapsiswa_id' => 2,
            ],
        ];

        foreach ($sikapSiswaTransaksi as $data) {
            \App\Models\Master\SikapSiswaTransaksi::create($data);
        }
    }
}
