<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusMasukSeeder extends Seeder
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
                'nama' => 'Murid baru',
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'nama' => 'Pindahan',
            ]
        ];
        foreach ($data as $d) {
            \App\Models\Master\StatusMasuk::create($d);
        }
    }
}
