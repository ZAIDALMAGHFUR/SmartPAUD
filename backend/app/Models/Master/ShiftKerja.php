<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftKerja extends Model
{
    use HasFactory;

    protected $table = 'shiftkerja';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'name',
        'jammasuk',
        'jampulang',
        'jambreakakhir',
        'jambreakawal',
        'factorrate',
    ];
}
