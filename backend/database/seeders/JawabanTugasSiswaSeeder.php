<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JawabanTugasSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jawabanTugasSiswa = [
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'kelassiswa_id' => 1,
                'tugassiswa_id' => 1,
                'guru_id' => 1,
                'tgljawab' => '2024-08-19 00:08:49',
                'nilaiakhir' => 100,
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'kelassiswa_id' => 2,
                'tugassiswa_id' => 2,
                'guru_id' => 2,
                'tgljawab' => '2024-08-19 00:08:49',
                'nilaiakhir' => 100,
            ],
        ];

        foreach ($jawabanTugasSiswa as $jawaban) {
            \App\Models\Master\JawabanTugasSiswa::create($jawaban);
        }
    }
}
