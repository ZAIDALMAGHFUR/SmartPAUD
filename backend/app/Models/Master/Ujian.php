<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    use HasFactory;

    protected $table = 'ujian';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'judul',
        'deskripsi',
        'durasi_ujian',
        'tahunajaran_id',
        'tipe_soal',
        'tipe_ujian',
        'random_soal',
        'random_jawaban',
        'lihat_hasil',
        'jadwalujian_id',
    ];

    public function jadwalUjian()
    {
        return $this->belongsTo(JadwalUjian::class);
    }
    public function TahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function UjianSiswa()
    {
        return $this->hasMany(UjianSiswa::class);
    }

    public function soalUjianPg()
    {
        return $this->hasMany(SoalUjianPg::class);
    }

    public function soalUjianEssay()
    {
        return $this->hasMany(SoalUjianEssay::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function MataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function getTipeSoalAttribute($value)
    {
        return $value == 'essay' ? 'Essay' : 'Pilihan Ganda';
    }
}
