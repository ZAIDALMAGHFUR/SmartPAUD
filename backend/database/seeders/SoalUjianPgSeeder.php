<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App;

class SoalUjianPgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        App\Models\Master\SoalUjianPG::create([
            'kdprofile' => '1',
            'statusenabled' => true,
            'nomor_soal' => 1,
            'pertanyaan' => 'What is the capital of France?',
            'pilihan_a' => 'Paris',
            'pilihan_b' => 'London',
            'pilihan_c' => 'Berlin',
            'pilihan_d' => 'Madrid',
            'pilihan_e' => 'Rome',
            'jawaban_benar' => 'a',
            'ujian_id' => 1,
        ]);

        App\Models\Master\SoalUjianPG::create([
            'kdprofile' => '1',
            'statusenabled' => true,
            'nomor_soal' => 2,
            'pertanyaan' => 'What is 2+2?',
            'pilihan_a' => '3',
            'pilihan_b' => '4',
            'pilihan_c' => '5',
            'pilihan_d' => '6',
            'pilihan_e' => '7',
            'jawaban_benar' => 'b',
            'ujian_id' => 1,
        ]);

        App\Models\Master\SoalUjianPG::create([
            'kdprofile' => '1',
            'statusenabled' => true,
            'nomor_soal' => 3,
            'pertanyaan' => 'Who wrote "Hamlet"?',
            'pilihan_a' => 'Charles Dickens',
            'pilihan_b' => 'J.K. Rowling',
            'pilihan_c' => 'William Shakespeare',
            'pilihan_d' => 'Mark Twain',
            'pilihan_e' => 'Leo Tolstoy',
            'jawaban_benar' => 'c',
            'ujian_id' => 1,
        ]);
    }
}
