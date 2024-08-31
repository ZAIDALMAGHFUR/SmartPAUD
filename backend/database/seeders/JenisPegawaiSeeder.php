<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisPegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $JenisPegawai = [
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru IPS'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru IPA'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Matematika'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Bahasa Indonesia'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Bahasa Inggris'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Seni Budaya'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Penjasorkes'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru BK'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru PPKn'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Agama Islam'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Agama Kristen'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Agama Katolik'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Agama Hindu'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Agama Buddha'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Agama Khonghucu'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru TIK'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Keterampilan'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Prakarya'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Ekonomi'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Geografi'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Sejarah'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Sosiologi'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Fisika'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Kimia'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Biologi'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Seni Musik'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Seni Tari'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru Seni Rupa'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Guru PKWU'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Staf Administrasi'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Staf Keuangan'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Staf Perpustakaan'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Staf Kebersihan'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Staf Keamanan'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Staf Laboratorium'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Koordinator Ekstrakurikuler'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Pengawas Sekolah'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Kepala Sekolah'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Wakil Kepala Sekolah'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'Programmer Administrator'],
        ];


        foreach ($JenisPegawai as $data) {
            \App\Models\Master\JenisPegawai::create($data);
        }
    }
}
