<?php

namespace App\Models;

use App\Models\Roles;
use App\Models\Master\Employee;
use App\Models\Master\Supporter;
use App\Models\Master\Witnesses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Users extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'password',
        'email',
        'first_name',
        'last_name',
        'roles_id',
        'is_active',
        'is_verified',
        'verification_token',
        'reset_token',
        'reset_token_expires_at',
        'last_login_at',
        'last_failed_login_at',
        'failed_login_count',
        'last_failed_login_ip',
        'last_login_ip',
        'timezone',
        'locale',
        'ip_address',
    ];

    protected $hidden = [
        'password',
    ];

    public function roles()
    {
        return $this->hasOne(Roles::class, 'id','roles_id');
    }
}
