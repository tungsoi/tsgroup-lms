<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseLesson extends Model
{
    protected $table = 'course_lessons';
    protected $fillable = [
        'course_id',
        'lesson_id',
    ];
    public function lesson() {
        return $this->belongsTo(Lesson::class);
    }
}
