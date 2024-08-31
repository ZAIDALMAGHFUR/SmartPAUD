<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPerkawinan extends Model
{
    use HasFactory;

    protected $table = 'statusperkawinan';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'name',
    ];
}
