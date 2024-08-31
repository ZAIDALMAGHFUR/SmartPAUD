<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusPendaftaran extends Seeder
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
                'nama' => 'Lulus',
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'nama' => 'Tidak Lulus',
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'nama' => 'Di Tolak',
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'nama' => 'Di Terima',
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'nama' => 'Lengkap',
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'nama' => 'Pending',
            ],
        ];
        foreach ($data as $d) {
            \App\Models\Master\StatusPendaftaran::create($d);
        }
    }
}
