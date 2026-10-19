<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    //public $timestamps = false;
    protected $fillable = [
        'course_code',	'course_name','description',	'duration_hours',	
        'course_fee'
        
        ];
}
