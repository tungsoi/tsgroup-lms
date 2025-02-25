<?php

namespace App\Admin\Controllers\Education;

use App\Models\Course;
use App\Models\CourseStudent;
use App\Models\Exam;
use App\Models\Lesson;
use App\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Tab;
use Illuminate\Support\Facades\Auth;

class LearningController extends AdminController
{
    protected $title = 'Khoá đang học';

    protected function grid()
    {
        $grid = new Grid(new Course());
        $courseId = CourseStudent::whereStudentId(Auth::id())->pluck('course_id')->toArray();
        $grid->model()->whereIn('id', $courseId);
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
        $grid->column('code', 'Mã khóa học');
        $grid->column('name', 'Tên khóa học');
        $grid->column('description', 'Mô tả');
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
        $grid->disableExport();
        $grid->disableCreateButton();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableDelete();
            $actions->disableEdit();
        });
        return $grid;
    }
    public function show($id, Content $content)
    {
        return $content->header($this->title)
            ->description('Chi tiết đơn hàng')
            ->row(function (Row $row) use ($id)
            {
                $row->column('12', function (Column $column) use ($id)
                {
                    $column->append((new Box('Thông tin khoá học', $this->detail($id))));
                });

                $row->column('8', function (Column $column) use ($id)
                {
                    $course = Course::find($id);
                    $link = $course->courseLessons->first()->lesson->content;
                    $link = $course->courseLessons->first()->lesson->content;
                    $column->append((new Box('Bài giảng', view('admin.exam.learn', compact('link'))->render())));
                });
                $row->column('4', function (Column $column) use ($id)
                {
                    $column->append((new Box('Bài kiểm tra', view('admin.exam.quest')->render())));
                });
            });
    }

    protected function detail($id)
    {
        $show = new Show(Course::findOrFail($id));
        $show->field('code', 'Mã khoá học');
        $show->field('name', 'Tên khoá học');
        $show->panel()
            ->tools(function ($tools) {
                $tools->disableEdit();
                $tools->disableList();
                $tools->disableDelete();
            });;
        return $show;
    }
}
