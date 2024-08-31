<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GolonganDarahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $golonganDarah = [
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'A'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'B'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'AB'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'O'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'A+'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'A-'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'B+'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'B-'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'AB+'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'AB-'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'O+'
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => 1,
                'name' => 'O-'
            ],
        ];

        foreach ($golonganDarah as $data) {
            \App\Models\Master\GolonganDarah::create($data);
        }
    }
}
