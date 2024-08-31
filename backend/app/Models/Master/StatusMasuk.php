<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusMasuk extends Model
{
    use HasFactory;

    protected $table = 'statusmasuk';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'nama',
    ];
}
