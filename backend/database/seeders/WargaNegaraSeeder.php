<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WargaNegaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wargaNegara = [
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'WNI'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'WNA'
            ],
        ];

        foreach ($wargaNegara as $data) {
            \App\Models\Master\WargaNegara::create($data);
        }
    }
}
