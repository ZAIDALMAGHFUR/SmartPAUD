<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalUjian extends Model
{
    use HasFactory;

    protected $table = 'jadwalujian';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'tanggal_ujian',
        'status_ujian',
        'started_at',
        'ended_at',
        'guru_can_manage',
        'guru_id',
        'matapelajaran_id',
        'kelas_id',
    ];

    public function guru()
    {
        return $this->belongsTo(Pegawai::class, 'guru_id');
    }

    public function matapelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'matapelajaran_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
