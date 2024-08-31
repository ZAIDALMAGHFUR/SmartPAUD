<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'name',
        'jenjangpendidikan_id',
    ];

    public function jenjangpendidikan()
    {
        return $this->belongsTo(JenjangPendidikan::class);
    }
}
