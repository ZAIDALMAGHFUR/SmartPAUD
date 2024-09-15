<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SoalUjianEssaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $soalEssays = [
            [
                'kdprofile' => '1',
                'statusenabled' => true,
                'nomor_soal' => 1,
                'pertanyaan' => 'Jelaskan konsep Pancasila sebagai dasar negara!',
                'ujian_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => true,
                'nomor_soal' => 2,
                'pertanyaan' => 'Bagaimana cara mengatasi perubahan iklim?',
                'ujian_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('soalujianessay')->insert($soalEssays);
    }
}
