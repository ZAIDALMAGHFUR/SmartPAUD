<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatan = [
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Kepala Sekolah'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Wakil Kepala Sekolah Kurikulum'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Wakil Kepala Sekolah Kesiswaan'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Kepala Tata Usaha'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Kepala Kurikulum'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Kepala Kesiswaan'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Kepala Keuangan'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Tetap'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Tidak Tetap'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Honorer'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Bantu'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Pengganti'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Staf Tata Usaha'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Staf Administrasi'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Staf Keuangan'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Staf Perpustakaan'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Staf Laboratorium'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Staf Koperasi'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Staf UKS'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Staf Kesiswaan'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Staf Humas'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Staf Sarana Prasarana'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Staf Keamanan'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Staf Kebersihan'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Penjaga Sekolah'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Penjaga Kebersihan'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Penjaga Keamanan'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Siswa'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Siswa Baru'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Siswa Pindahan'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Siswa Keluar'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Alumni'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Orang Tua Siswa']
        ];

        foreach ($jabatan as $jab) {
            App\Models\Master\Jabatan::create($jab);
        }
    }
}
