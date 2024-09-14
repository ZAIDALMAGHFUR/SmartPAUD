<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasSiswa extends Model
{
    use HasFactory;

    protected $table = 'kelassiswa';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'siswa_id',
        'tahunajaran_id',
        'kelas_id',
        'walikelas_id'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahunajaran_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function waliKelas()
    {
        return $this->belongsTo(Pegawai::class, 'walikelas_id');
    }
}
