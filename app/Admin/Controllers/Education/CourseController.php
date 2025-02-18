<?php

namespace App\Admin\Controllers\Education;

use App\Models\Course;
use App\Models\Lesson;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Hash;

class CourseController extends AdminController
{

    protected function title()
    {
        return 'Khóa học';
    }

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
        $grid->column('name', 'Tên khóa học')->editable();
        $grid->column('code', 'Mã khóa học')->editable();
        $grid->column('description', 'Mô tả')->editable();
        $grid->column('number_of_students', 'Số lượng học viên')->editable();
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
        $form->text('name', 'Têm khóa học');
        $form->text('code', 'Mã khóa học');
        $form->text('description', 'Mô tả');
        $form->number('number_of_students', 'Số lượng học viên');
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
