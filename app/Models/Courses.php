<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'course_code',  
        'course_name',
        'description',    
        'duration_hours',   
        'course_fee'
    ];

    public function students()
    {
        return $this->hasMany(LaravelStudent::class, 'course_id');
    }
}