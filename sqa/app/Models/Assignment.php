<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assignment extends Model
{
     use HasFactory;
    protected $table = 'assignments';

    protected $primaryKey = 'assignment_id';

    protected $fillable = ['course_id','title', 'due_date', 'due_time', 'description', 'file_path'];

    protected $casts = ['due_date' => 'date', 'due_time' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }



}
