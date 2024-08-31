<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanTugasSiswaDetail extends Model
{
    use HasFactory;

    protected $table = 'jawabantugassiswadetail';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'jawabantugassiswa_id',
        'tugassiswadetail_id',
        'jawabanpilihan',
        'jawabanessay',
        'iscorrect',
        'nilai',
    ];

    public function jawabanTugasSiswa()
    {
        return $this->belongsTo(JawabanTugasSiswa::class, 'jawabantugassiswa_id');
    }

    public function tugasSiswaDetail()
    {
        return $this->belongsTo(TugasSiswaDetail::class, 'tugassiswadetail_id');
    }
}
