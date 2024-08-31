<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPpdb extends Model
{
    use HasFactory;

    protected $table = 'jadwalppdb';

    protected $fillable = [
        'statusenabled',
        'kdprofile',
        'nama',
        'jeniskegiatan',
        'tglmulai',
        'tglakhir',
        'tahunajaran_id',
    ];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}
