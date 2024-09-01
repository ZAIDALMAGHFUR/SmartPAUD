<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusTempatTinggalSeeder extends Seeder
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
                'nama' => 'Orang tua',
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Menumpang',
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Asrama',
            ],
        ];

    foreach ($data as $d) {
        \App\Models\Master\StatusTempatTinggal::create($d);
    }
    }
}
