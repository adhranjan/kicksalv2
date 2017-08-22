@extends('front.inlcudes.front_detault')
<link href="{{ asset('assets/web/css/noty.css') }}" rel="stylesheet" type="text/css" media="all" />
@section('body')
    <div class="container">
        <div class="register register_min">
                <div class="register-top-grid">
                    <h3>Verify Phone</h3>
                    <div class="mation">
                        <input type="text" name="phone" id="phone" autofocus placeholder="Phone Number">
                        <div class="recapcha">
                            <div id="recaptcha-container"></div>
                        </div>
                        <div class="verification_code_parent" style="display: none">
                            <input type="text" name="verification_code" id="verification_code" placeholder="Code We Sent">
                        </div>
                        <br>
                        <button class="btn btn-success">Proceed</button>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            <div class="clearfix"> </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="https://www.gstatic.com/firebasejs/4.2.0/firebase.js"></script>
    <script src="{{ asset('assets/web/js/noty.min.js') }}"></script>
    <script src="{{ asset('assets/web/js/phoneValidator.js') }}"></script>
    <script>
        var url="{{ route('input_phone') }}";
        var phoneUpdateUrl="{{ route('player_update_phone') }}";
    </script>
    @endsection
</body>
</html>