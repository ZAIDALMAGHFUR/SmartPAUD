<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Master\MataPelajaran;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Pengembangan Diri',
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Pengenalan Lingkungan',
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'nama' => 'Matematika',
            ],
        ];

        foreach ($data as $item) {
            MataPelajaran::create($item);
        }
    }
}
