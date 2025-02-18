<?php

namespace App\Admin\Controllers\Report;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Widgets\Box;

class CourseController extends Controller
{
    public function chart1(Content $content)
    {
        return $content
            ->header('Chartjs')
            ->body(new Box('Bar chart', view('admin.chart.chart1')));
    }

    public function chart2(Content $content)
    {
        return $content
            ->header('Chartjs')
            ->body(new Box('Bar chart', view('admin.chart.chart2')));
    }

}
