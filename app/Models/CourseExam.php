<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseExam extends Model
{
    protected $table = 'course_exams';
    protected $fillable = [
        'course_id',
        'exam_id',
    ];
}
