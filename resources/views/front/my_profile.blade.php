@extends('front.inlcudes.front_detault')
@section('header')
    <link href="{{ asset('assets/admin/vendors/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('body')
    <div id="gal" class="gallery">
        <div class="container">
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                    <div class="regard-in">
                        <a href="#" data-toggle="modal" data-target="#dpChanger"><span class="camera"> </span></a>
                        <p><a href="#"><i id="user_name_parent"> {{ $profile->user_name }} </i> <i id="user_name_input_holder" style="display: none">
                                    <input type="text" value="{{ $profile->user_name }}" id="user_name_input"> </i> <i id="user_name_edit" class="fa fa-pencil-square-o"></i> </a></p>
                        <img class="img-responsive ago" id="user_dp" src="{{ $profile->avatar }}?width=400" alt="">
                        <p class="col-d">
                                weired message here
                        </p>
                        <div class="clearfix"> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="content-app-up">
                <div class="container">
                    <div class="mydiv"></div>
                    <h3>My Bookings</h3>
                    <div class="regard">
                        @foreach($bookings as $booking)
                            <div class="regard-in">
                                <p>{{ $booking->game_day }} -{{ date("l", strtotime($booking->game_day )) }} ({{ $booking->book_time }})</p>
                                <p><a href="{{ route('futsal_detail_home',$booking->bookedForGround->futsal->slug) }}">{{  '@'.$booking->bookedForGround->futsal->name }}</a> @if($booking->bookedForGround->futsal->address ), {{ $booking->bookedForGround->futsal->address }} @endif , Ground: {{ $booking->bookedForGround->name }}
                                </p>
                            </div>
                        @endforeach



                    </div>
                </div>
            </div>
            <!---->
        </div>
    </div>
    <div id="dpChanger" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Choose New Profile Picture</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route'=>['player_front_profile_change_dp'],'method'=>'PUT','class'=>'dropzone','files' => true]) !!}

                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>

@endsection
@section('footer')
    <script src="{{ asset('assets/admin/vendors/dropzone/dist/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/web/js/dpchanger.js') }}"></script>
    <script>
        var user_name_change_route="{{ route('change_my_username') }}";
    </script>
@endsection
</body>
</html>