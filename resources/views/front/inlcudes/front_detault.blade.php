<!DOCTYPE html>
<html>
<head>
    <title>{{ $title??'Kicksal' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/web/css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('assets/admin/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">



    <script src="{{ asset('assets/web/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/web/js/bootstrap.min.js') }}"></script>


    <link href="{{ asset('assets/web/css/style.css') }}" rel="stylesheet" type="text/css" media="all" />
    <!--//theme-style-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!--fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Passion+One:400,700,900' rel='stylesheet' type='text/css'>
    <link href="{{ asset('assets/web/css/noty.css') }}" rel="stylesheet" type="text/css" media="all" />
    <script src="{{ asset('assets/web/js/noty.min.js') }}"></script>
    <!--//fonts-->

</head>
<body>

@include('front.inlcudes.header')
@yield('header')
@yield('body')
@include('front.inlcudes.footer')
@include('front.inlcudes.notification')
@yield('footer')


</body>
</html>