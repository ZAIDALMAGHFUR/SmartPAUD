<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenjangPendidikan extends Model
{
    use HasFactory;

    protected $table = 'jenjangpendidikan';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'name',
    ];
}
