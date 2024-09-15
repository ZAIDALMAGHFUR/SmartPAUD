<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Master\UjianSiswa;

class UjianSiswaSeeder extends Seeder
{
    public function run()
    {
        UjianSiswa::create([
            'kdprofile' => '1',
            'statusenabled' => true,
            'ujian_id' => 1,
            'siswa_id' => 1,
            'started_at' => now(),
            'ended_at' => now()->addMinutes(90),
            'nilai' => 85,
            'user_agent' => 'Mozilla/5.0',
            'ip_address' => '192.168.1.1',
            'status' => '1',
        ]);

        UjianSiswa::create([
            'kdprofile' => '1',
            'statusenabled' => true,
            'ujian_id' => 2,
            'siswa_id' => 2,
            'started_at' => now(),
            'ended_at' => now()->addMinutes(60),
            'nilai' => 78,
            'user_agent' => 'Mozilla/5.0',
            'ip_address' => '192.168.1.2',
            'status' => '1',
        ]);

        UjianSiswa::create([
            'kdprofile' => '1',
            'statusenabled' => true,
            'ujian_id' => 3,
            'siswa_id' => 3,
            'started_at' => now(),
            'ended_at' => now()->addMinutes(120),
            'nilai' => 92,
            'user_agent' => 'Mozilla/5.0',
            'ip_address' => '192.168.1.3',
            'status' => '1',
        ]);
    }
}
