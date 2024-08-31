<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusPerkawinanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statusPerkawinan = [
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Belum Kawin'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Kawin'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Cerai Hidup'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Cerai Mati'
            ],
        ];

        foreach ($statusPerkawinan as $data) {
            \App\Models\Master\StatusPerkawinan::create($data);
        }
    }
}
