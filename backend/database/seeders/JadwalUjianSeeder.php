<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Master\JadwalUjian;

class JadwalUjianSeeder extends Seeder
{
    public function run()
    {
        JadwalUjian::create([
            'kdprofile' => '1',
            'statusenabled' => true,
            'tanggal_ujian' => '2024-09-20',
            'status_ujian' => 'aktif',
            'started_at' => '09:00',
            'ended_at' => '11:00',
            'guru_can_manage' => '1',
            'guru_id' => 1,
            'kelas_id' => 1,
            'matapelajaran_id' => 1,
        ]);

        JadwalUjian::create([
            'kdprofile' => '1',
            'statusenabled' => true,
            'tanggal_ujian' => '2024-09-21',
            'status_ujian' => 'nonaktif',
            'started_at' => '10:00',
            'ended_at' => '12:00',
            'guru_can_manage' => '0',
            'guru_id' => 2,
            'kelas_id' => 2,
            'matapelajaran_id' => 2,
        ]);

        JadwalUjian::create([
            'kdprofile' => '1',
            'statusenabled' => false,
            'tanggal_ujian' => '2024-09-22',
            'status_ujian' => 'draft',
            'started_at' => '09:00',
            'ended_at' => '11:00',
            'guru_can_manage' => '0',
            'guru_id' => 3,
            'kelas_id' => 3,
            'matapelajaran_id' => 3,
        ]);
    }
}
