<?php

namespace App\Models\Master;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogingUsers extends Model
{
    use HasFactory;

    protected $table = 'loging_users';

    protected $fillable = [
        'users_id',
        'ipaddress',
        'browser',
        'activity',
        'url',
        'method',
        'keterangan',
        'device',
        'tgllogin',
        'waktulogin',
    ];

    public function users()
    {
        return $this->belongsTo(App\Models\Users::class);
    }
}
