<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisKelaminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => '-'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Laki-laki'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Perempuan'
            ],
        ];

        foreach ($data as $item) {
            \App\Models\Master\JenisKelamin::create($item);
        }
    }
}
