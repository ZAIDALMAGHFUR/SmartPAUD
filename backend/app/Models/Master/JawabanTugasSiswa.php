<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanTugasSiswa extends Model
{
    use HasFactory;

    protected $table = 'jawabantugassiswa';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'kelassiswa_id',
        'tugassiswa_id',
        'guru_id',
        'tgljawab',
        'nilaiakhir',
    ];

    public function tugasSiswa()
    {
        return $this->belongsTo(TugasSiswa::class, 'tugassiswa_id');
    }

    public function KelasSiswa()
    {
        return $this->belongsTo(KelasSiswa::class, 'kelassiswa_id');
    }

    public function guru()
    {
        return $this->belongsTo(Pegawai::class, 'guru_id');
    }

    public function jawabanTugasSiswaDetails()
    {
        return $this->hasMany(JawabanTugasSiswaDetail::class, 'jawabantugassiswa_id');
    }
}
