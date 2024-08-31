<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App;

class KategorypegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoryPegawai = [
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'PNS'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'BLU PKWT'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'BLU TETAP'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'OUTSOURCING'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'PARUH WAKTU'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => '-'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'CPNS'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'HARIAN LEPAS'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'MITRA'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'PESERTA DIDIK'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'DOKTER TAMU'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'BLUD'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'PGDS'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'PTT'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'BLUD KONTRAK'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'BLUD TETAP'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Dokter Spesialis PTT'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Dokter Spesialis Tamu'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Dokter Umum PTT'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Honor Pemda'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'PPPK'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'PEGAWAI TAMU (REFRAKSIONIS)'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Sukwan'],
        ];

        foreach ($kategoryPegawai as $item) {
            App\Models\Master\Kategorypegawai::create($item);
        }
    }
}
