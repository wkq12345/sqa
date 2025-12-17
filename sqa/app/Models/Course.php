<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'course_code',
        'course_title',
        'description',
        'category',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: A course has many assignments
     */
    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'course_id', 'id');
    }

    /**
     * Accessor: Get full course name (for views using $course->name)
     */
    public function getNameAttribute()
    {
        return $this->course_title;
    }
}