<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EkstrakurikulerSiswa extends Model
{
    use HasFactory;

    protected $table = 'ekstrakurikulersiswa';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'kelassiswa_id',
        'guru_id',
        'tglmasuk',
        'tglkeluar',
        'keterangan',
        'ekstrakurikuler_id',
    ];

    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class);
    }

    public function guru()
    {
        return $this->belongsTo(Pegawai::class);
    }
    public function KelasSiswa()
    {
        return $this->belongsTo(KelasSiswa::class);
    }
}
