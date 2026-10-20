<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaravelStudent extends Model
{
    protected $table = 'laravel_students'; // Database ထဲက Table နာမည်ကို အတိအကျ ချိတ်ဆက်ပေးခြင်း

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