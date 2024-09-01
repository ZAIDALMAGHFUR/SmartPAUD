<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPembayaran extends Model
{
    use HasFactory;

    protected $table = 'jenispembayaran';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'nama'
    ];
}
