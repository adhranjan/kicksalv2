
<!DOCTYPE html>
<html>
<head>
    <title>Kicksal- Login</title>
    <link href="{{ asset('assets/web/css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{ asset('assets/web/js/jquery.min.js') }}"></script>
    <!-- Custom Theme files -->
    <!--theme-style-->
    <link href="{{ asset('assets/web/css/style.css') }}" rel="stylesheet" type="text/css" media="all" />

    <!--//theme-style-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!--fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Passion+One:400,700,900' rel='stylesheet' type='text/css'>
    <!--//fonts-->
</head>
<body>
<!--content-->
<div class="container">
    <div class="register">
        {!! Form::open(['url'=>'login','method'=>'POST','novalidate','data-parsley-validate']) !!}
        <div class="register-top-grid">
            <h3>Login</h3>
            <div class="mation">
                <div>
                    <input id="email" type="email"  required="required" name="email" value="{{ old('email') }}" placeholder="Email">
                </div>
                <div>
                    <input id="password" type="password" required="required" name="password" placeholder="Password">
                </div>
                @if ($errors->has('email'))
                    <div >
                        <p class="text-danger">{{ $errors->first('email') }}</p>
                    </div>
                @endif
                @if ($errors->has('password'))
                    <div >
                        <p class="text-danger">{{ $errors->first('password') }}</p>
                    </div>
                @endif
            </div>
            <div class="clearfix"> </div>
            <button type="submit" class="btn btn-success">Login</button>
        </div>
        {!! Form::close() !!}
        <a href="{{ route('google_login_request') }}">
            <button class="loginBtn loginBtn--google">
                Login/Register via Google
            </button>
        </a>
        <div class="clearfix"> </div>
    </div>
</div>
</body>
</html>

{{--

<button class="loginBtn loginBtn--facebook">
    Login with Facebook
</button>--}}
