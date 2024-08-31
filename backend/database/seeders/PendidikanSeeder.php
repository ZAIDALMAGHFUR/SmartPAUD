<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pendidikan = [
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Tidak Sekolah'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'SD'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'SMP'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'SMA'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'D3'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'S1'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'S2'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'S3'
            ],
        ];

        foreach ($pendidikan as $data) {
            \App\Models\Master\Pendidikan::create($data);
        }
    }
}
