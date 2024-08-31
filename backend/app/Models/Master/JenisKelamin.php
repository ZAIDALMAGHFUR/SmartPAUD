<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKelamin extends Model
{
    use HasFactory;

    protected $table = 'jeniskelamin';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'name',
    ];
}
