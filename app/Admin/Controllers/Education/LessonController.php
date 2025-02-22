<?php

namespace App\Admin\Controllers\Education;

use App\Models\Lesson;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Hash;

class LessonController extends AdminController
{

    protected function title()
    {
        return 'Bài Giảng';
    }

    protected function grid()
    {
        $grid = new Grid(new Lesson());
        $grid->expandFilter();
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->column(1 / 2, function ($filter) {
                $filter->like('name', 'Tên bài giảng');
            });
        });

        $grid->rows(function (Grid\Row $row) {
            $row->column('number', ($row->number + 1));
        });
        $grid->column('number', 'STT');
        $grid->column('name', 'Tên bài giảng')->editable();
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
        return new Show(Lesson::findOrFail($id));
    }

    public function form()
    {
        $form = new Form(new Lesson());
        $form->text('name', 'Têm bài giảng');
        $form->summernote('content');
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
