<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPembayaran extends Model
{
    use HasFactory;

    protected $table = 'statuspembayaran';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'nama',
    ];
}
