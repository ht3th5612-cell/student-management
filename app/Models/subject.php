<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class subject extends Model
{
    //
    protected $fillable = [
        'subject_name',
        'description',
        'course_id'
    ];

    public function courses()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }
}
