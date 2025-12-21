<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';
    protected $fillable = [
        'name',
        'identification_number',
        'photo',
        'gender',
        'phone',
        'address',
        'student_id',
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

    public function modules()
    {
        return $this->hasMany(Module::class, 'student_id');
    }
}
