<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App;

class GolonganPegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $golonganPegawai = [
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'I/IVb'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'IV/a'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'III/d'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'III/c'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'III/b'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'II/d'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => 'III/a'],
            ['kdprofile' => '1', 'statusenabled' => '1', 'name' => '-']
        ];

        foreach ($golonganPegawai as $gol) {
            App\Models\Master\GolonganPegawai::create($gol);
        }
    }
}
