<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Master\KelasSiswa;

class KelasSiswaSeeder extends Seeder
{
    public function run()
    {
        KelasSiswa::create([
            'kdprofile' => '1',
            'statusenabled' => true,
            'siswa_id' => 1,
            'tahunajaran_id' => 1,
            'kelas_id' => 1,
            'walikelas_id' => 1,
            'tglmasuk' => '2021-08-01',
            'tglkeluar' => null,
            'keterangan' => 'Siswa baru',
        ]);

        KelasSiswa::create([
            'kdprofile' => '1',
            'statusenabled' => true,
            'siswa_id' => 1,
            'tahunajaran_id' => 2,
            'kelas_id' => 2,
            'walikelas_id' => 2,
            'tglmasuk' => '2021-08-01',
            'tglkeluar' => null,
            'keterangan' => 'Siswa baru',
        ]);

        KelasSiswa::create([
            'kdprofile' => '1',
            'statusenabled' => false,
            'siswa_id' => 1,
            'tahunajaran_id' => 3,
            'kelas_id' => 3,
            'walikelas_id' => 3,
            'tglmasuk' => '2021-08-01',
            'tglkeluar' => null,
            'keterangan' => 'Siswa baru',
        ]);
    }
}
