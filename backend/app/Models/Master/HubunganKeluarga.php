<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HubunganKeluarga extends Model
{
    use HasFactory;

    protected $table = 'hubungankeluarga';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'name',
    ];
}
