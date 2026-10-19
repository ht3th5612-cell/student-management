<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class laravel_students extends Model
{
    protected $fillable = [
        'student_code',
        'name',
        'email',
        'phone',
        'gender',
        'course_id'
    ];

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }
}