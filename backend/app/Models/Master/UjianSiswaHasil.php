<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UjianSiswaHasil extends Model
{
    use HasFactory;

    protected $table = 'ujiansiswahasil';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'ujiansiswa_id',
        'soalujianpg_id',
        'soalujianessay_id',
        'jawaban',
        'ragu',
        'status',
        'guru_id',
        'komentar_guru',
    ];

    public function ujiansiswa()
    {
        return $this->belongsTo(UjianSiswa::class, 'ujiansiswa_id');
    }

    public function soalujianpg()
    {
        return $this->belongsTo(SoalUjianPG::class, 'soalujianpg_id');
    }

    public function soalujianessay()
    {
        return $this->belongsTo(SoalUjianEssay::class, 'soalujianessay_id');
    }

    public function guru()
    {
        return $this->belongsTo(Pegawai::class, 'guru_id');
    }
}
