<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jadwal = [
            'Senin' => [
                ['07:00:00', '08:00:00', 1, 1, 1,1,'Upacara'],
                ['08:00:00', '09:30:00', 1, 1, 1,1,'Pelajaran'],
                ['09:30:00', '09:45:00', 1, 1, 1,1,'Istirahat'],
                ['09:45:00', '11:15:00', 1, 2, 2,2,'Pelajaran'],
                ['11:30:00', '13:00:00', 1, 3, 3,3,'Pelajaran'],
            ],
            'Selasa' => [
                ['07:00:00', '08:00:00', 1, 1, 1,1,'Literasi'],
                ['08:00:00', '09:30:00', 1, 1, 1,1,'Pelajaran'],
                ['09:30:00', '09:45:00', 1, 1, 1,1,'Istirahat'],
                ['09:45:00', '11:15:00', 1, 2, 2,2,'Pelajaran'],
                ['11:30:00', '13:00:00', 1, 3, 3,3,'Pelajaran'],
            ],
            'Rabu' => [
                ['07:00:00', '08:00:00', 1, 1, 1,1,'Literasi'],
                ['08:00:00', '09:30:00', 1, 1, 1,1,'Pelajaran'],
                ['09:30:00', '09:45:00', 1, 1, 1,1,'Istirahat'],
                ['09:45:00', '11:15:00', 1, 2, 2,2,'Pelajaran'],
                ['11:30:00', '13:00:00', 1, 3, 3,3,'Pelajaran'],
            ],
            'Kamis' => [
                ['07:00:00', '08:00:00', 1, 1, 1,1,'Literasi'],
                ['08:00:00', '09:30:00', 1, 1, 1,1,'Pelajaran'],
                ['09:30:00', '09:45:00', 1, 1, 1,1,'Istirahat'],
                ['09:45:00', '11:15:00', 1, 2, 2,2,'Pelajaran'],
                ['11:30:00', '13:00:00', 1, 3, 3,3,'Pelajaran'],
            ],
            'Jumat' => [
                ['07:00:00', '08:00:00', 1, 1, 1,1,'Literasi'],
                ['08:00:00', '09:30:00', 1, 1, 1,1,'Pelajaran'],
                ['09:30:00', '09:45:00', 1, 1, 1,1,'Istirahat'],
                ['09:45:00', '11:15:00', 1, 2, 2,2,'Pelajaran'],
                ['11:30:00', '13:00:00', 1, 3, 3,3,'Jumatan'],
            ]
        ];

        foreach ($jadwal as $hari => $sesi) {
            foreach ($sesi as $data) {
                DB::table('jadwalpelajaran')->insert([
                    'kdprofile' => '1',
                    'statusenabled' => true,
                    'hari' => $hari,
                    'jam_mulai' => $data[0],
                    'jam_selesai' => $data[1],
                    'jenis_kegiatan' => $data[6],
                    'kelas_id' => $data[2],
                    'matapelajaran_id' => $data[3],
                    'guru_id' => $data[4],
                    'tahunajaran_id' => $data[5],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
