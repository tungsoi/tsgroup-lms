<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';
    protected $fillable = [
        'name',
        'code',
        'description'
    ];
    public function courseExams()
    {
        return $this->hasMany(CourseExam::class,'course_id', 'id');
    }
    public function courseLessons()
    {
        return $this->hasMany(CourseLesson::class,'course_id', 'id');
    }

    public function courseStudents()
    {
        return $this->hasMany(CourseStudent::class,'course_id', 'id');
    }

}
