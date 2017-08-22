@if(!$profile)
    @section('header')
        <link href="{{ asset('assets/web/css/sweetalert.min.css') }}" rel="stylesheet" type="text/css" media="all" />
    @endsection
    <a href="{{ route('player_update_phone') }}" id="mobile_pick_btn" class="btn btn-success">Fill Your Mobile</a>
@section('footer')
    <script src="{{ asset('assets/web/js/sweetalert.min.js') }}"></script>
    <script>

          swal({
                    title: "Update",
                    type: "info",
                    text: "Provide your mobile number to continue.",
                    confirmButtonText: "Continue",
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href = "{{ route('player_update_phone') }}";
                    }
                });</script>
@endsection
@endif