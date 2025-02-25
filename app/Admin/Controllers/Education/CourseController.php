<?php

namespace App\Admin\Controllers\Education;

use App\Models\Course;
use App\Models\Exam;
use App\Models\Lesson;
use App\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CourseController extends AdminController
{
    protected $title = 'Khoá học';

    protected function grid()
    {
        $grid = new Grid(new Course());
        $grid->expandFilter();
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->column(1 / 2, function ($filter) {
                $filter->like('name', 'Tên khóa học');
            });
        });

        $grid->rows(function (Grid\Row $row) {
            $row->column('number', ($row->number + 1));
        });
        $grid->column('number', 'STT');
        $grid->column('code', 'Mã khóa học')->editable();
        $grid->column('name', 'Tên khóa học')->editable();
        $grid->column('description', 'Mô tả')->editable();
        $grid->column('courseLessons', 'Bài giảng')->display(function ($courseLessons) {
            return count($courseLessons);
        });
        $grid->column('courseExams', 'Bài kiểm tra')->display(function ($courseExams) {
            return count($courseExams);
        });
        $grid->column('courseStudents', 'Học viên')->display(function ($courseStudents) {
            return count($courseStudents);
        });
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

    protected function detail($id)
    {
        return new Show(Course::findOrFail($id));
    }

    public function form()
    {
        $form = new Form(new Course());
        $form->text('name', 'Têm khóa học')->required();
        $form->text('code', 'Mã khóa học')->required();
        $form->text('description', 'Mô tả')->required();
        $form->divider('Bài giảng');
        $form->hasMany('courseLessons', '',  function (Form\NestedForm $form) {
            $form->select('lesson_id', 'Tên bài giảng')->options(Lesson::all()->pluck('name', 'id'))->required();
        });
        $form->divider('Bài kiểm tra');
        $form->hasMany('courseExams', '', function (Form\NestedForm $form) {
            $form->select('exam_id', 'Tên bài kiểm tra')->options(Exam::all()->pluck('name', 'id'))->required();
        });
        $form->divider('Học viên');
        $form->hasMany('courseStudents', '', function (Form\NestedForm $form) {
            $form->select('student_id', 'Họ và tên')->options(User::whereIsStudent(User::STUDENT)->get()->pluck('name', 'id'))->required();
        });
        $form->disableEditingCheck();
        $form->disableCreatingCheck();
        $form->disableViewCheck();
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });
        return $form;
    }
}
