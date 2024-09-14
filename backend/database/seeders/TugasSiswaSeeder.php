<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TugasSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tugasSiswa = [
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Tugas 1',
                'type' => 'link',
                'file_or_link' => 'https://www.youtube.com/watch?v=6v2L2UGZJAM',
                'kelas_id' => 1,
                'tahunajaran_id' => 1,
                'guru_id' => 1,
                'matapelajaran_id' => 1,
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Tugas 2',
                'type' => 'link',
                'file_or_link' => 'https://www.youtube.com/watch?v=6v2L2UGZJAM',
                'kelas_id' => 2,
                'tahunajaran_id' => 2,
                'guru_id' => 2,
                'matapelajaran_id' => 2,
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'Tugas 3',
                'type' => 'link',
                'file_or_link' => 'https://www.youtube.com/watch?v=6v2L2UGZJAM',
                'kelas_id' => 3,
                'tahunajaran_id' => 3,
                'guru_id' => 3,
                'matapelajaran_id' => 3,
            ],
        ];

        foreach ($tugasSiswa as $tugas) {
            \App\Models\Master\TugasSiswa::create($tugas);
        }
    }
}
