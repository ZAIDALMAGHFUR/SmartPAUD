<?php

namespace Database\Seeders;

use App\Models\Master\RaportSiswa;
use Illuminate\Database\Seeder;

class RaportSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RaportSiswa::create([
            'kdprofile' => '1',
            'statusenabled' => true,
            'kelassiswa_id' => 1,
            'kelas_id' => 1,
            'tahunajaran_id' => 1,
            'guru_id' => 1,
            'matapelajaran_id' => 1,
            'jumlahkdpengetahuan' => 5,
            'nilaipengetahuan' => 85,
            'predikatpengetahuan' => 'B',
            'jumlahkdketerampilan' => 4,
            'nilaiketerampilan' => 87,
            'predikatketerampilan' => 'B',
            'ratarata' => 86,
            'catatanwalikelas' => 'Good progress!',
            'tanggapanorangtua' => 'We are satisfied with the improvement.',
        ]);
        RaportSiswa::create([
            'kdprofile' => '1',
            'statusenabled' => true,
            'kelassiswa_id' => 1,
            'kelas_id' => 1,
            'tahunajaran_id' => 1,
            'guru_id' => 1,
            'matapelajaran_id' => 2,
            'jumlahkdpengetahuan' => 5,
            'nilaipengetahuan' => 95,
            'predikatpengetahuan' => 'A',
            'jumlahkdketerampilan' => 4,
            'nilaiketerampilan' => 97,
            'predikatketerampilan' => 'A',
            'ratarata' => 96,
            'catatanwalikelas' => 'Good progress!',
            'tanggapanorangtua' => 'We are satisfied with the improvement.',
        ]);
        RaportSiswa::create([
            'kdprofile' => '1',
            'statusenabled' => true,
            'kelassiswa_id' => 1,
            'kelas_id' => 1,
            'tahunajaran_id' => 1,
            'guru_id' => 1,
            'matapelajaran_id' => 3,
            'jumlahkdpengetahuan' => 5,
            'nilaipengetahuan' => 75,
            'predikatpengetahuan' => 'C',
            'jumlahkdketerampilan' => 4,
            'nilaiketerampilan' => 77,
            'predikatketerampilan' => 'C',
            'ratarata' => 76,
            'catatanwalikelas' => 'Good progress!',
            'tanggapanorangtua' => 'We are satisfied with the improvement.',
        ]);
    }
}
