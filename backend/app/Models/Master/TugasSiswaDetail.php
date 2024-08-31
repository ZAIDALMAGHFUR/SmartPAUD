<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasSiswaDetail extends Model
{
    use HasFactory;

    protected $table = 'tugassiswadetail';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'tugassiswa_id',
        'pertanyaan',
        'pilihanjawaban',
        'jawabanbenar',
        'is_essay',
        'jawaban_essay',
    ];

    public function tugasSiswa()
    {
        return $this->belongsTo(TugasSiswa::class, 'tugassiswa_id');
    }
}
