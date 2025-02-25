<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\AdminBuilder;

class Answer extends Model
{
    use AdminBuilder;
    protected $table = "answers";
    protected $fillable = ['question_id', 'is_correct', 'content'];
}