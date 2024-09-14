<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    use HasFactory;

    protected $table = 'jadwalpelajaran';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'jenis_kegiatan',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'kelas_id',
        'matapelajaran_id',
        'guru_id',
        'tahunajaran_id',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'matapelajaran_id');
    }

    public function guru()
    {
        return $this->belongsTo(Pegawai::class, 'guru_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahunajaran_id');
    }
}
