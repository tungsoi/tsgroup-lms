<?php

use Illuminate\Routing\Router;

Route::group([
    'prefix' => '',
    'namespace' => 'App\\Admin\\Controllers\\Home',
    'middleware' => ['web'],
    'as' => 'home.',
], function (Router $router) {
    $router->get(
        '/',
        'IndexController@index'
    )->name('index');
    $router->get('about', 'IndexController@about')->name('about');
    $router->get('proxy', 'IndexController@proxy')->name('proxy');
    $router->get('register', 'RegisterController@index')->name('register');
    $router->post('register', 'RegisterController@register')->name('postRegister');
    $router->get('forgotPassword', 'ForgotPasswordController@getForgotPassword')->name('getForgotPassword');
    $router->post('postForgotPassword', 'ForgotPasswordController@postForgotPassword')->name('postForgotPassword');
    $router->get('getVerifyForgotPassword', 'ForgotPasswordController@getVerifyForgotPassword')->name('getVerifyForgotPassword');
    $router->post('postVerifyForgotPassword', 'ForgotPasswordController@postVerifyForgotPassword')->name('postVerifyForgotPassword');
});

Admin::routes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => [
        'web',
        'admin',
        'admin.permission:deny,customer'
    ],
    'as' => config('admin.route.prefix') . '.',
], function (Router $router) {
});

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
    'as' => config('admin.route.prefix') . '.',
], function (Router $router) {
    $router->get('', 'System\\HomeController@blank')->name('blank');
    $router->get('home', 'System\\HomeController@index')->name('home');
    $router->resources([
        'auth/roles' => 'System\\RoleController',
        'auth/users' => 'System\\UserController',
        'students' => 'System\\StudentController',
        'exams' =>  'Education\\ExamController',
        'lessons' => 'Education\\LessonController',
        'courses' => 'Education\\CourseController',
    ]);
    $router->get('chart1', 'Report\\CourseController@chart1');
    $router->get('chart2', 'Report\\CourseController@chart2');
});
