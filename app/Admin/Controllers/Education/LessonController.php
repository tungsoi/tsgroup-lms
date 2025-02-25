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
    protected $title = 'Danh sách Bài giảng';

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
        $grid->name('Tên bài giảng')->editable();
        $grid->description('Mô tả')->editable();
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
        $form = new Form(new Lesson());
        $form->text('name', 'Tên bài giảng')->required();
        $form->textarea('description', 'Mô tả')->required();
        $form->textarea('content', 'Link bài giảng')->required();
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
