<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JalurPendaftaran extends Model
{
    use HasFactory;

    protected $table = 'jalurpendaftaran';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'name',
    ];
}
