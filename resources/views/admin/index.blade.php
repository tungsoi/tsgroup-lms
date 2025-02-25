<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ Admin::title() }} @if($header)
            | {{ $header }}
        @endif</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="{{ asset('home/images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400&display=swap" rel="stylesheet">
    {!! Admin::css() !!}
    <script src="{{ Admin::jQuery() }}"></script>
    {!! Admin::headerJs() !!}

    <style>
        .main-header {
            height: 0px !important;
            display: none;
        }

        @media only screen and (max-width: 900px) {
            .main-header {
                display: block;
                height: auto !important;
            }

            .box-header, .box-body {
                overflow: scroll;
            }
        }

        tfoot {
            display: table-row-group !important;
            background: #3c763d !important;
            color: white !important;
            font-weight: bold !important;
        }
        .user-panel>.image>img {
            width: 45px !important;
            height: 45px !important;
            border-radius: 4px !important;
        }
        #exam-create .question-container {
            margin-bottom: 20px;
            border: 1px solid #d2d6de;
            padding: 10px;
        }

        #exam-create .answers {
            margin-top: 20px;
        }

        #exam-create .answer {
            margin-bottom: 10px;
        }

        #exam-create .remove-question-btn {
            margin-top: 10px;
        }

        #exam-create .answer-correct {
            transform: scale(1.5);
        }

        #exam-create .table td, #exam-create .table th {
            vertical-align: middle;
        }

        #exam-create .table input[type="text"] {
            width: 100%;
        }

        #exam-create .btn-sm {
            font-size: 12px;
        }

        #exam-create .add-answer {
            margin-bottom: 5px;
        }
    </style>
</head>
<body class="hold-transition {{config('admin.skin')}} {{join(' ', config('admin.layout'))}}">
@if($alert = config('admin.top_alert'))
    <div style="text-align: center;padding: 5px;font-size: 12px;background-color: #ffffd5;color: #ff0000;">
        {!! $alert !!}
    </div>
@endif
<div class="loading-overlay">
    <i class="fa fa-spinner fa-spin" style="color: green"></i> Vui lòng đợi trong giây lát ...
</div>
<div class="wrapper">
    @include('admin::partials.header')
    @include('admin::partials.sidebar')
    <div class="content-wrapper" id="pjax-container">
        {!! Admin::style() !!}
        <div id="app">
            @yield('content')
        </div>
        {!! Admin::script() !!}
        {!! Admin::html() !!}
    </div>
</div>
<script>
    function LA() {
    }

    LA.token = "{{ csrf_token() }}";
    LA.user = @json($_user_);
</script>

{!! Admin::js() !!}
</html>
