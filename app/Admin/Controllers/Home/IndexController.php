<?php

namespace App\Admin\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\System\Alert;

class IndexController extends Controller
{
    public function index()
    {
        return view('home.index');
    }

    public function about()
    {
        return view('home.about');
    }

    public function proxy()
    {
        return view('home.proxy');
    }


}
