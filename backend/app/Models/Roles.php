<?php

namespace App\Models;

use App\Models\User;
use App\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Roles extends Model
{
    use HasFactory;

    // Table Name
    protected $table = 'roles';

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(Users::class, 'id');
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'id');
    }
}
