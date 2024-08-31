<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pekerjaan = [
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'PNS'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'TNI'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'POLRI'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Pegawai Swasta'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Wiraswasta'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Petani'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Nelayan'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Buruh'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Pensiunan'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Pelajar'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Mahasiswa'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Ibu Rumah Tangga'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Lainnya'
            ],
        ];

        foreach ($pekerjaan as $item) {
            \App\Models\Master\Pekerjaan::create($item);
        }
    }
}
