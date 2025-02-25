<style>
    .li-logo {
        display: flex !important;
        background: white !important;
        overflow: hidden;
        padding: 15px 10px !important;
        border-right: 1px solid #5d869d;
    }
    .li-logo img {
        flex-basis: fit-content;
        width: 90%;
        margin: 0 auto;
    }
</style>
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="li-logo">
                <img src="{{ asset('images/logo.png') }}" alt="">
            </li>
            <li class="">
                <a class="sidebar-toggle" data-toggle="offcanvas" role="button" status="right">
                    <i class="fa fa-chevron-right"></i>
                </a>
            </li>
        </ul>
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ Admin::user()->avatar }}" class="img-radius-10" alt="User Image">
            </div>
            <div class="pull-left info">
                <a href="#"><i class="fa fa-circle text-success"></i> {{ Admin::user()->roles->first()->name }}</a> <br> <br>
                <a href="#"><i class="fa fa-circle text-success"></i> {{ Admin::user()->name }}</a>
            </div>
        </div>
        <ul class="sidebar-menu">
            @each('admin::partials.menu', Admin::menu(), 'item')
        </ul>
        <ul class="sidebar-menu" style="background: #0b446d;">
            <li class="">
                <a href="{{route('admin.setting')}}">
                    <i class="fa fa-sun-o"></i>
                    <span>Cài đặt cá nhân</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.logout') }}" id="btn-logout">
                    <i class="fa fa-sign-out"></i>
                    <span>Đăng xuất</span>
                </a>
            </li>
        </ul>
    </section>
</aside>