<?php

return [
    'name' => env('APP_NAME', 'Laravel'),
    'logo' => '<b>' . env('APP_NAME', 'Laravel') . '</b>',
    'logo-mini' => '<b>TSG</b>',
    'bootstrap' => app_path('Admin/bootstrap.php'),
    'route' => [
        'prefix' => env('ADMIN_ROUTE_PREFIX', 'admin'),
        'namespace' => 'App\\Admin\\Controllers',
        'middleware' => ['web', 'admin'],
    ],
    'directory' => app_path('Admin'),
    'title' => 'Admin',
    'https' => env('ADMIN_HTTPS', true),
    'auth' => [
        'controller' => App\Admin\Controllers\AuthController::class,
        'guard' => 'admin',
        'guards' => [
            'admin' => [
                'driver' => 'session',
                'provider' => 'admin',
            ],
        ],
        'providers' => [
            'admin' => [
                'driver' => 'eloquent',
                'model' => App\User::class,
            ],
        ],
        'remember' => true,
        'redirect_to' => 'auth/login',
        'excepts' => [
            'auth/login',
            'auth/logout',
        ],
    ],
    'upload' => [
        'disk' => 'admin',
        'directory' => [
            'image' => 'images',
            'file' => 'files',
        ],
    ],
    'database' => [
        'connection' => '',
        'users_table' => 'admin_users',
        'users_model' => Encore\Admin\Auth\Database\Administrator::class,
        'roles_table' => 'admin_roles',
        'roles_model' => Encore\Admin\Auth\Database\Role::class,
        'permissions_table' => 'admin_permissions',
        'permissions_model' => Encore\Admin\Auth\Database\Permission::class,
        'menu_table' => 'admin_menu',
        'menu_model' => Encore\Admin\Auth\Database\Menu::class,
        'operation_log_table' => 'admin_operation_log',
        'user_permissions_table' => 'admin_user_permissions',
        'role_users_table' => 'admin_role_users',
        'role_permissions_table' => 'admin_role_permissions',
        'role_menu_table' => 'admin_role_menu',
    ],
    'operation_log' => [
        'enable' => false,
        'allowed_methods' => ['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'],
        'except' => [
            env('ADMIN_ROUTE_PREFIX', 'admin') . '/auth/logs*',
        ],
    ],
    'check_route_permission' => true,
    'check_menu_roles' => true,
    'default_avatar' => '/vendor/laravel-admin/AdminLTE/dist/img/user2-160x160.jpg',
    'map_provider' => 'google',
    'skin' => 'skin-red',
    'layout' => ['sidebar-mini'],
    'login_background_image' => '/images/login-bg.jpeg',
    'show_version' => false,
    'show_environment' => false,
    'menu_bind_permission' => true,
    'enable_default_breadcrumb' => false,
    'minify_assets' => [
        'excepts' => [
        ],
    ],
    'enable_menu_search' => false,
    'top_alert' => '',
    'grid_action_class' => \App\Admin\Extensions\CustomActions::class,
    'extension_dir' => app_path('Admin/Extensions'),
    'extensions' => [
        'chartjs' => [
            'enable' => true,
        ],
        'grid-lightbox' => [
            'enable' => true,
        ],
        'material-ui' => [
            'enable' => false
        ],
        'summernote' => [
            'enable' => true,
            'config' => [
            ]
        ]
    ],
];
