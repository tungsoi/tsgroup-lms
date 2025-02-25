<?php

namespace App\Admin\Controllers\System;

use App\Admin\Controllers\TransportOrder\TransportCodeController;
use App\Http\Controllers\Controller;
use App\User;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\InfoBox;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title('Bảng điều khiển')
            ->row(function (Row $row) {});
    }

    public function blank()
    {
        return redirect()->route('admin.home');
    }

    public function updateDeviceToken(Request $request)
    {
        $token = $request->token;

        User::find(Admin::user()->id)->update([
            'device_key' => $token
        ]);

        return response()->json([
            'status' => 200,
            'msg' => $token
        ]);
    }
}
