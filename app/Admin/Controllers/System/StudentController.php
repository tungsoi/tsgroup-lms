<?php

namespace App\Admin\Controllers\System;

use App\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentController extends AdminController
{
    protected $title = 'Danh sách học viên';

    protected function grid()
    {
        $grid = new Grid(new User());
        $grid->model()->whereIsStudent(User::STUDENT);
        $grid->expandFilter();
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();

            $filter->column(1 / 3, function ($filter) {
                $filter->like('name', 'Họ và tên');
            });
            $filter->column(1 / 3, function ($filter) {
                $filter->like('username', 'Email');
            });
            $filter->column(1 / 3, function ($filter) {
                $filter->like('phone_number', 'Số điện thoại');
            });
            Admin::style('
                #filter-box label {
                    padding: 0px !important;
                    padding-top: 10px;
                    font-weight: 600;
                    font-size: 12px;
                }
                #filter-box .col-sm-2 {
                    width: 100% !important;
                    text-align: left;
                    padding: 0px 15px 3px 15px !important;
                }
                #filter-box .col-sm-8 {
                    width: 100% !important;
                }
            ');
        });

        $grid->rows(function (Grid\Row $row) {
            $row->column('number', ($row->number + 1));
        });
        $grid->column('number', 'STT');
        $grid->avatar()->lightbox(['width' => 40]);
        $grid->name('Họ và tên')->editable();
        $grid->username('Tài khoản');
        $grid->email('Email')->editable();
        $grid->phone_number('Số diện thoại')->editable();
        $grid->address('Địa chỉ')->editable();
        $grid->note('Ghi chú')->editable();
        $states = [
            'on' => ['value' => User::ACTIVE, 'text' => 'Mở', 'color' => 'success'],
            'off' => ['value' => User::DEACTIVE, 'text' => 'Khoá', 'color' => 'danger'],
        ];
        $grid->column('is_active', 'Trạng thái')->switch($states)->style('text-align: center');
        $grid->disableBatchActions();
        $grid->disableColumnSelector();
        $grid->paginate(20);
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableView();
        });
        return $grid;
    }

    public function form()
    {
        $form = new Form(new User());
        $form->text('username', 'Tên đăng nhập')->default(Str::random(15))->disable();
        $form->text('name', 'Họ và tên')->rules('required');
        $form->text('email', 'Email')->rules('required');
        $form->text('phone_number', 'Số điện thoại')->rules('required');
        $states = [
            'on' => ['value' => User::ACTIVE, 'text' => 'Mở', 'color' => 'success'],
            'off' => ['value' => User::DEACTIVE, 'text' => 'Khoá', 'color' => 'danger'],
        ];
        $form->text('note', 'Ghi chú');
        $form->text('address', 'Địa chỉ')->rules('required');
        $form->divider();
        $form->password('password', trans('admin.password'))->rules('confirmed|required');
        $form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')
        ->default(function ($form) {
            return $form->model()->password;
        });
        $form->divider();
        $form->switch('is_active', 'Trạng thái tài khoản')->states($states);
        $form->ignore(['password_confirmation']);
        $form->hidden('is_student')->value(User::STUDENT);
        $form->saving(function (Form $form) {
            if ($form->password && $form->model()->password != $form->password) {
                $form->password = Hash::make($form->password);
            }
        });
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });
        return $form;
    }
}
