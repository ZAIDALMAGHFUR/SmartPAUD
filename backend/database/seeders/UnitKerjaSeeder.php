<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App;

class UnitKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unitKerja = [
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Kepala Sekolah'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Wakil Kepala Sekolah'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Guru'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Staf Tata Usaha'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Staf Administrasi'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Perpustakaan'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Laboratorium'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Keuangan'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Humas'],
        ];

        foreach ($unitKerja as $uk) {
            App\Models\Master\UnitKerja::create($uk);
        }
    }
}
