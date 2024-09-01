<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisPembayaranSeeder extends Seeder
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
                'nama' => 'SPP'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Uang Gedung'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Uang Seragam'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Uang Kegiatan'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Uang Praktikum'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Uang Ujian'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Uang KKN'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Uang Pendaftran'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Uang Kost'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Uang Makan'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Uang Transportasi'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Uang Kesehatan'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Uang Asuransi'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Uang Lainnya'
            ],
        ];

        foreach ($data as $item) {
            \App\Models\Master\JenisPembayaran::create($item);
        }
    }
}
