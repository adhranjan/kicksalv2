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
    @yield('header')

</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        @include('includes.header')
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
<script src="{{ asset('assets/admin/vendors/validator/validator.js') }}"></script>


@yield('footer')

@include('includes.notification')

<!-- Custom Theme Scripts -->
<script src="{{ asset('assets/admin/build/js/custom.min.js') }}"></script>
<!-- My Custom Scripts -->
@yield('below_footer')

</body>
</html>
