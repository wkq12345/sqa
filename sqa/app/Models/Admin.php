<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';

    protected $fillable = [
        'admin_id',
        'name',
        'gender',
        'phone',
        'address',
        'identification_number',
        'photo',
        'user_id',
        'role_id',
    ];
}
