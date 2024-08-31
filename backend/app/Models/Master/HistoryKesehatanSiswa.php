<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryKesehatanSiswa extends Model
{
    use HasFactory;

    protected $table = 'historykesehatansiswa';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'siswatransaksi_id',
        'guru_id',
        'keluhan',
        'diagnosa',
        'tindakan',
        'keterangan',
    ];

    public function siswaTransaksi()
    {
        return $this->belongsTo(SiswaTransaksi::class);
    }

    public function guru()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
