<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SikapSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Sangat Baik',
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Baik',
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Cukup',
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Kurang',
            ],
        ];

        foreach ($data as $item) {
            \App\Models\Master\SikapSiswa::create($item);
        }
    }
}
