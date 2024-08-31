<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App;

class StatusPegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Aktif'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Tenaga Pendidik'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Tenaga Kependidikan'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Staf Administrasi'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Staf Non Akademik'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Belajar DN (Bujang Keluarga)'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Pensiun (Berhenti)'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Meninggal'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Pindah'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Hukuman Disiplin'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Belajar LN (Bujang)'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Dipekerjakan (Satker Baru)'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Uang Tunggu'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Dipekerjakan (Satker Asal)'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => '-'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Fungsional Non Aktif'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Perpanjangan Usia Pensiun'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Penghentian Jabatan Eselon'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Penghentian Jabatan Eselon (MPP)'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Dipekerjakan Satker Asal-Meninggal'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Dipekerjakan Satker Baru - Meninggal'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Dipekerjakan Satker Asal-BUP'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Dipekerjakan Satker Baru - BUP'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Non Aktif'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Berhenti'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Keluar'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Purna Bakti'],
        ];

        foreach ($data as $item) {
            App\Models\Master\StatusPegawai::create($item);
        }
    }
}
