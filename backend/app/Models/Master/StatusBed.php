<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusBed extends Model
{
    use HasFactory;

    protected $table = 'statusbed';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'name',
    ];
}
