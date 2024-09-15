<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UjianSiswaHasilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kdprofile' => '1',
                'statusenabled' => true,
                'ujiansiswa_id' => 1,
                'soalujianpg_id' => 1,
                'soalujianessay_id' => null,
                'jawaban' => 'A',
                'ragu' => 'Tidak',
                'status' => 'Selesai',
                'guru_id' => 1,
                'komentar_guru' => 'Jawaban bagus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => true,
                'ujiansiswa_id' => 2,
                'soalujianpg_id' => null,
                'soalujianessay_id' => 1,
                'jawaban' => 'Penjelasan lengkap',
                'ragu' => 'Ya',
                'status' => 'Selesai',
                'guru_id' => 1,
                'komentar_guru' => 'Perlu perbaikan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('ujiansiswahasil')->insert($data);
    }
}
