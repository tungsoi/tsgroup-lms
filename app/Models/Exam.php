<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use AdminBuilder;
    protected $table = 'exams';
    protected $fillable = [
        'name',
        'content'
    ];
    public function questions() {
        return $this->hasMany('App\Models\Question', 'exam_id', 'id');
    }
}
