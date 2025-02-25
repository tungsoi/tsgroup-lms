<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\AdminBuilder;

class Question extends Model
{
    use AdminBuilder;
    protected $table = "questions";
    protected $fillable = ['exam_id', 'title', "note"];
    public function answers() {
        return $this->hasMany('App\Models\Answer', 'question_id', 'id');
    }
    public static function getArrAnswer($id) {
        $question = self::find($id);
        $answer = $question->answers->pluck('id')->toArray();
        return $answer;
    }
    public static function getArrCorrectAnswer($id) {
        $question = self::find($id);
        $answer = $question->answers->where('is_correct', 1)->pluck('id')->toArray();
        return $answer;
    }
    public static function getArrayString($key) {
        $data = [
            0 => 'A',
            1 => 'B',
            2 => 'C',
            3 => 'D',
            4 => 'E',
            5 => 'F',
            6 => 'G',
            7 => 'H',
            8 => 'I',
            9 => 'K',
            10 => 'L',
            11 => 'M',
            12 => 'N',
            13 => 'O'
        ];

        return $data[$key] ?? "";
    }
}