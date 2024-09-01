<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusPembayaranSeeder extends Seeder
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
                'nama' => 'Belum Lunas'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'nama' => 'Lunas'
            ],
        ];

        foreach ($data as $item) {
            \App\Models\Master\StatusPembayaran::create($item);
        }
    }
}
