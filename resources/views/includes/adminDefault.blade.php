<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <!-- Bootstrap -->
    <link href="{{ asset('assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('assets/admin/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('assets/admin/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('assets/admin/build/css/custom.min.css') }} " rel="stylesheet">
    <!-- My Custom Style -->
    <link href="{{ asset('assets/admin/customstyle.css') }} " rel="stylesheet">
    @yield('header')

</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        @php($folder= explode('_',Auth::User()->roles()->first()->name)[0])
        @include('includes.'.$folder.'.header')
        <!-- page content -->
        <div class="right_col" role="main">
            @yield('body_content')
        </div>
        <!-- /page content -->
        @include('includes.footer')
    </div>
</div>

<!-- jQuery -->
<script src="{{ asset('assets/admin/vendors/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('assets/admin/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('assets/admin/vendors/iCheck/icheck.min.js') }}"></script>
<!-- Custom Theme Scripts -->
<script src="{{ asset('assets/admin/build/js/custom.min.js') }}"></script>
<!-- My Custom Scripts -->
<script src="{{ asset('assets/admin/customscript.js') }}"></script>
@yield('footer')
@if(\Illuminate\Support\Facades\Session::has('status'))
    <div id="custom_notifications" class="custom-notifications dsp_none">
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>
    <script>
        $(document).ready(function() {
            TabbedNotification = function(options) {
                var message = "<div id='ntf' class='text alert-" + options.type + "' style='display:none'><h2><i class='fa fa-bell'></i> " + options.title +
                        "</h2><div class='close'><a href='javascript:;' class='notification_close'><i class='fa fa-close'></i></a></div><p>" + options.text + "</p></div>";
                $('#custom_notifications #notif-group').append(message);
                $('.tabbed_notifications > div:first-of-type').show();

            };
            $(document).on('click', '.notification_close', function(e) {
                $('#ntf').remove();
                $('#ntlink').parent().remove();
                $('.notifications a').first().addClass('active');
                $('#notif-group div').first().css('display', 'block');
            });
            new TabbedNotification({
                title: '{{ Session::get('head') }}',
                text: '{{ Session::get('message') }}',
                type: '{{ Session::get('status') }}',
                sound: false
            })
        });
    </script>
@endif

</body>
</html>
