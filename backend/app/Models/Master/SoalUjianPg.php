<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalUjianPg extends Model
{
    use HasFactory;

    protected $table = 'soalujianpg';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'nomor_soal',
        'pertanyaan',
        'pilihan_a',
        'pilihan_b',
        'pilihan_c',
        'pilihan_d',
        'pilihan_e',
        'jawaban_benar',
        'ujian_id'
    ];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }
}
