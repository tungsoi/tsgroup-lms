<?php

namespace App\Admin\Controllers\System;

use App\Admin\Services\UserService;
use App\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Widgets\Table;
use Illuminate\Support\Facades\Hash;

class StudentController extends AdminController
{
    protected $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * {@inheritdoc}
     */
    protected function title()
    {
        return 'Danh sách khách hàng';
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());
        $grid->model()->whereIsStudent(User::STUDENT);
        $grid->expandFilter();
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();

            $filter->column(1 / 4, function ($filter) {
                $filter->like('name', 'Họ và tên');
            });
            $filter->column(1 / 4, function ($filter) {
                $filter->like('username', 'Email');
            });
            $filter->column(1 / 4, function ($filter) {
                $filter->like('phone_number', 'Số điện thoại');
            });
            $filter->column(1 / 4, function ($filter) {
                $filter->between('created_at', 'Ngày tạo tài khoản')->date();
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
        $grid->id('Hồ sơ')->display(function () {
            return "Tất cả";
        })->expand(function ($model) {
            $info = [
                "ID" => $model->id,
                "Địa chỉ Email" => $model->email,
                "Số điện thoại" => $model->phone_number,
                "Ngày mở tài khoản" => date('H:i | d-m-Y', strtotime($this->created_at)),
                "Địa chỉ" => $model->address,
            ];

            return new Table(['Thông tin', 'Nội dung'], $info);
        })->style('width: 100px; text-align: center;');
        $grid->wallet('Ví tiền')->display(function () {
            $label = $this->wallet < 0 ? "red" : "green";
            return "<span style='color: {$label}'>" . number_format($this->wallet) . "</span>";
        })->style('text-align: right; max-width: 150px;');
        $states = [
            'on' => ['value' => User::ACTIVE, 'text' => 'Mở', 'color' => 'success'],
            'off' => ['value' => User::DEACTIVE, 'text' => 'Khoá', 'color' => 'danger'],
        ];
        $grid->note('Ghi chú')->editable()->style('max-width: 150px;');
        $grid->column('is_active', 'Trạng thái')->switch($states)->style('text-align: center');
        $grid->disableCreateButton();
        $grid->disableBatchActions();
        $grid->disableColumnSelector();
        $grid->paginate(20);
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableView();
        });
        return $grid;
    }

    protected function detail($id)
    {
        return redirect()->route('admin.customers.index');
    }

    public function form()
    {
        $class = config('admin.database.users_model');

        $form = new Form(new $class());
        $form->setTitle('Cập nhật thông tin');

        $service = new UserService();
        $form->column(1 / 2, function ($form) use ($service) {
            $form->display('username', 'Tên đăng nhập');
            $form->text('name', 'Họ và tên')->rules('required');
            $form->text('phone_number', 'Số điện thoại')->rules('required');
            $form->divider();
            $states = [
                'on' => ['value' => User::ACTIVE, 'text' => 'Mở', 'color' => 'success'],
                'off' => ['value' => User::DEACTIVE, 'text' => 'Khoá', 'color' => 'danger'],
            ];
            $form->switch('is_active', 'Trạng thái tài khoản')->states($states);
            $form->text('note', 'Ghi chú');
        });
        $form->column(1 / 2, function ($form) use ($service) {
            $form->text('address', 'Địa chỉ')->rules('required');
            $form->divider();
            $form->password('password', trans('admin.password'))->rules('confirmed|required');
            $form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')
                ->default(function ($form) {
                    return $form->model()->password;
                });
            $form->divider();
        });

        $form->ignore(['password_confirmation']);
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

    public function script()
    {
        return <<<SCRIPT
            $("input[name='_method']").val('POST');
SCRIPT;
    }

}
