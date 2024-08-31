<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App;

class KelompokpegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelompokPegawai = [
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Tenaga Pendidik'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Tenaga Kependidikan'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Peserta Didik'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Calon Pegawai'],
        ];

        foreach ($kelompokPegawai as $item) {
            App\Models\Master\KelompokPegawai::create($item);
        }
    }
}
