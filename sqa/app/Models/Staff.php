<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staffs';
    protected $fillable = [
        'name',
        'identification_number',
        'gender',
        'phone',
        'address',
        'photo',
        'staff_id',
        'user_id',
        'role_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
