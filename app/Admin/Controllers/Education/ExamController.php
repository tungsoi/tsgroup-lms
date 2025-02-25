<?php

namespace App\Admin\Controllers\Education;

use App\Models\Exam;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;

class ExamController extends AdminController
{
    protected $title = 'Bài kiểm tra';

    protected function grid()
    {
        $grid = new Grid(new Exam());
        $grid->expandFilter();
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->column(1 / 2, function ($filter) {
                $filter->like('name', 'Tên bài kiểm tra');
            });
        });

        $grid->rows(function (Grid\Row $row) {
            $row->column('number', ($row->number + 1));
        });
        $grid->column('number', 'STT');
        $grid->column('name', 'Tên bài kiểm tra')->editable();
        $grid->column('created_at', 'Ngày tạo')->display(function () {
            return date('H:i | d-m-Y', strtotime($this->created_at));
        })->style('text-align: center');
        $grid->disableBatchActions();
        $grid->disableColumnSelector();
        $grid->paginate(20);
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
        });
        return $grid;
    }

    public function form()
    {
        $form = new Form(new Exam);
        $form->text('name','Tên bài kiểm tra')->required();
        $form->divider('Câu hỏi');
        $form->hidden('content');
        $form->html(view('admin.exam.create')->render());
        $form->disableEditingCheck();
        $form->disableCreatingCheck();
        $form->disableViewCheck();
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });
        Admin::style('
            tfoot {
                background-color: white !important;
            }
        ');
        return $form;
    }

    public function storeRebuild(Request $request)
    {
        $data = $this->formatRequestData($request->all());
        Exam::create([
            'name' => $request->name,
            'content' => json_encode($data),
        ]);
        return redirect()->route('admin.exams.index');
    }

    public function updateRebuild(Request $request, $id) {
        $data = $this->formatRequestData($request->all());
        Exam::find($id)->update([
            'name'  =>  $request->name,
            'content' => json_encode($data),
        ]);
        return redirect()->route('admin.exams.index');
    }

    public function formatRequestData($data) {
        $questions = [];

        foreach ($data as $key => $value) {
            if (strpos($key, 'question-') === 0) {
                $questionId = str_replace('question-', '', $key);
                if (!isset($questions[$questionId])) {
                    $questions[$questionId] = [
                        'id' => $questionId,
                        'content' => $value,
                        'answers' => []
                    ];
                }
            }

            if (strpos($key, 'answer-') === 0) {
                $parts = explode('-', $key);
                $questionId = $parts[1];
                if (strpos($key, 'correct-answer-') === false) {
                    $answerContent = $value;
                    $isCorrect = isset($data["correct-answer-$questionId-$parts[2]"]) ? true : false;
                    $questions[$questionId]['answers'][] = [
                        'content' => $answerContent,
                        'is_correct' => $isCorrect
                    ];
                }
            }
        }

        return ['questions' => array_values($questions)];
    }

}
