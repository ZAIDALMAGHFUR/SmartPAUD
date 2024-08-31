<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TahunAjaranSeeder extends Seeder
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
                'nama' => 'Semester 1 Tahun Ajaran 2021/2022',
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Semester 2 Tahun Ajaran 2022/2023',
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Semester 1 Tahun Ajaran 2023/2024',
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Semester 2 Tahun Ajaran 2024/2025',
            ],
        ];

        foreach ($data as $item) {
            \App\Models\Master\TahunAjaran::create($item);
        }
    }
}
