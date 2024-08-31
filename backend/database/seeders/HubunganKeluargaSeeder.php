<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HubunganKeluargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hubunganKeluarga = [
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Ayah'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Ibu'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Anak'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Kakek'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Nenek'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Saudara'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Suami'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Istri'
            ],
        ];

        foreach ($hubunganKeluarga as $data) {
            \App\Models\Master\HubunganKeluarga::create($data);
        }
    }
}
