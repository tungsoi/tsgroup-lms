<?php

use Encore\Admin\Facades\Admin;

Encore\Admin\Form::forget(['map', 'editor']);
app('view')->prependNamespace('admin', resource_path('views/admin'));
Admin::favicon('favicon.png');
Admin::js('vendor/exam/exam.js');
