<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSiswaSeeder extends Seeder
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
                'nama' => 'Lulus',
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'DO',
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Cuti',
            ]
        ];

        foreach ($data as $d) {
            \App\Models\Master\StatusSiswa::create($d);
        }
    }
}
