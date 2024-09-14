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
                'nama' => 'Kelas A',
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Kelas A Kecil',
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Kelas A Besar',
            ],
        ];

        foreach ($data as $kelas) {
            \App\Models\Master\Kelas::create($kelas);
        }
    }
}
