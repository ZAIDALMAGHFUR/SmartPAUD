<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Master\PrestasiSiswa;

class PrestasiSiswaSeeder extends Seeder
{
    public function run()
    {
        PrestasiSiswa::create([
            'kdprofile' => '1',
            'statusenabled' => true,
            'siswa_id' => 1,
            'jenisprestasi' => 'Akademik',
            'namaprestasi' => 'Olimpiade Matematika',
            'tingkatprestasi' => 'Nasional',
            'peringkat' => 'Juara 1',
            'penyelenggara' => 'Universitas Indonesia',
            'tanggalprestasi' => '2024-06-01',
            'dokumenprestasi' => 'link-to-document.pdf',
        ]);

        PrestasiSiswa::create([
            'kdprofile' => '1',
            'statusenabled' => true,
            'siswa_id' => 2,
            'jenisprestasi' => 'Olahraga',
            'namaprestasi' => 'Kejuaraan Sepak Bola',
            'tingkatprestasi' => 'Provinsi',
            'peringkat' => 'Juara 2',
            'penyelenggara' => 'PSSI',
            'tanggalprestasi' => '2024-05-15',
            'dokumenprestasi' => 'link-to-document.pdf',
        ]);
    }
}
