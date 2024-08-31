<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpdbPembayaran extends Model
{
    use HasFactory;

    protected $table = 'ppdbpembayaran';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'ppdb_id',
        'jenispembayaran_id',
        'statuspembayaran_id',
        'jumlah',
        'keterangan',
        'tglbayar',
        'photo',
    ];

    public function ppdb()
    {
        return $this->belongsTo(Ppdb::class);
    }

    public function jenisPembayaran()
    {
        return $this->belongsTo(JenisPembayaran::class);
    }

    public function statusPembayaran()
    {
        return $this->belongsTo(StatusPembayaran::class);
    }
}
