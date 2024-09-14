<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SikapSiswaTransaksi extends Model
{
    use HasFactory;

    protected $table = 'sikapsiswatransaksi';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'kelassiswa_id',
        'guru_id',
        'tglmasuk',
        'tglkeluar',
        'keterangan',
        'sikapsiswa_id',
    ];

    public function sikapSiswa()
    {
        return $this->belongsTo(SikapSiswa::class, 'sikapsiswa_id');
    }

    public function KelasSiswa()
    {
        return $this->belongsTo(KelasSiswa::class);
    }

    public function guru()
    {
        return $this->belongsTo(Pegawai::class, 'guru_id');
    }
}
