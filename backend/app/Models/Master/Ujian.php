<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    use HasFactory;

    protected $table = 'ujians';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'judul',
        'deskripsi',
        'durasi_ujian',
        'tipe_soal',
        'tipe_ujian',
        'random_soal',
        'random_jawaban',
        'lihat_hasil',
        'jadwalujian_id',
    ];

    public function getTipeSoalAttribute($value)
    {
        return $value == 'essay' ? 'Essay' : 'Pilihan Ganda';
    }

    public function jadwalujian()
    {
        return $this->belongsTo(JadwalUjian::class, 'jadwalujian_id');
    }
}
