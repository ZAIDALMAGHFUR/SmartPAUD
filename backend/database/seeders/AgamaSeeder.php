<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Islam'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Kristen Protestan'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Kristen Katolik'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Hindu'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Budha'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Konghucu'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Aliran Kepercayaan'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Lainnya'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'K. Bethel'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'K. Pantekosta'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Simp Katolik'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Advent'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'name' => 'Orthodoks'],
        ];

        foreach ($data as $item) {
            \App\Models\Master\Agama::create($item);
        }
    }
}
