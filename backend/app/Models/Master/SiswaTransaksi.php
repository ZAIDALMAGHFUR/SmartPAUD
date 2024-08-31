<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiswaTransaksi extends Model
{
    use HasFactory;

    protected $table = 'siswatransaksi';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'siswa_id',
        'kelas_id',
        'tahunajaran_id',
        'guru_id',
        'tglmasuk',
        'tglkeluar',
        'keterangan',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function guru()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
