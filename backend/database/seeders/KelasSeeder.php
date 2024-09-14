<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
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
                'nama' => 'A Bersar',
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'A Kecil',
            ],
        ];

        foreach ($data as $kelas) {
            \App\Models\Master\Kelas::create($kelas);
        }
    }
}
