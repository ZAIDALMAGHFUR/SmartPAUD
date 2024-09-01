<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusTempatTinggal extends Model
{
    use HasFactory;

    protected $table = 'statustempattinggal';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'name',
    ];
}
