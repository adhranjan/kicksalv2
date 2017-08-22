@extends('front.inlcudes.front_detault')
@section('body')
    <div id="gal" class="gallery">
        <div class="container">
            <div class="head pull-left">
                <h3>{{ $futsal->name }}
                </h3>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
                    <img class="img-responsive port-pic" src="{{ $futsal->avatar_id }}">
                </div>
                <div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
                </div>
                @if($profile)
                    <div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
                        <p class="size"><a class="none fa  {{ $profile->favouriteFutsals()->find($futsal->id)?'fa-heart':'fa-heart-o' }}" id="fav_btn" aria-hidden="true"></a> <span id="fav_msg"></span> </p>
                        {!! Form::open(['route'=>['futsal_book_home',$futsal->slug],'method'=>'POST','class'=>'form-horizontal form-label-left','files' => true]) !!}
                        <p class="size">Choose Date:
                            {!! Form::date('game_day', null,['class'=>$errors->first('game_day')?'parsley-error':''.'','required'=>'required','id'=>'game_day','Placeholder'=>'Game Day']) !!}
                            @if($errors->first('game_day'))
                                <small><i class="text-danger">{{ $errors->first('game_day') }}</i></small>
                            @endif
                        </p>
                        <p class="size">Choose Time:
                            {!! Form::select('book_time',$book_time, null,['class'=>$errors->first('book_time')?'':''.'','required'=>'required','id'=>'book_time']) !!}
                            @if($errors->first('book_time'))
                                <small> <i class="text-danger">{{ $errors->first('book_time') }}</i></small>
                            @endif
                        </p>
                        <input type="hidden" name="phone" value="{{ $profile->phone }}">
                        <p class="size">Preferred Ground:
                            {!! Form::select('ground_id',$ground_id, null,['class'=>$errors->first('ground_id')?'':''.'','required'=>'required','id'=>'ground_id']) !!}
                            @if($errors->first('ground_id'))
                                <small><i class="text-danger">{{ $errors->first('book_time') }}</i></small>
                            @endif
                        </p>
                        <button vaue="Submit"  type="submit" class="btn btn-success">Proceed</button>
                        {!! Form::close() !!}
                    </div>
                @endif
            </div>
            <div class="mydiv"></div>
            <div class="row">
                <div class="col-md-6 col-xs-6 col-sm-6 col-lg-6">
                    <p class="size_">Booking This Week</p>
                    <table class="my_table table table-striped service-list">
                        <tr>
                            <th>Day</th>
                            <th>Time</th>
                        </tr>
                        @foreach($bookings as $booking)
                            <tr>
                                <td>{{ $booking->game_day }} - {{ date("l", strtotime($booking->game_day )) }}</td>
                                <td>{{ $booking->book_time }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="col-md-6 col-xs-6 col-sm-6 col-lg-6">
                    @if($profile)
                    <p class="size_">My Coming Games</p>
                    <table class="my_table table table-striped service-list">
                        <tr>
                            <th>Day</th>
                            <th>Booked Time</th>
                            <th>Status</th>
                        </tr>
                        @foreach($myBookings as $booking)
                            <tr>
                                <td>{{ $booking->game_day }} - {{ date("l", strtotime($booking->game_day )) }}</td>
                                <td>{{ $booking->book_time }}</td>
                                <td>{{ $booking->status }}  @if($booking->payment_status  != 'Paid') <a href="#" title="Pay Now" class="fa fa-paypal"></a> @endif</td>
                            </tr>
                        @endforeach
                    </table>
                    @endif
                </div>
            </div>
        </div>
{{--
        <div class="content">
            <div class="content-app-up">
                <div class="container">
                    <div class="mydiv"></div>
                    <h3>News And Events</h3>
                    <div class="regard">
                        <div class="regard-in">
                            <p><a href="#"> about a day ago we replied to </a></p>
                            <p>@danielcook1996  Hi Daniel, we are sorry that we can't get something out to you sooner. If you have any questions regarding...</p>
                            <a href="#"><span> </span></a>
                        </div>
                        <div class="regard-in">
                            <a href="#"><span class="camera"> </span></a>
                            <p><a href="#"> about a day ago we replied to </a></p>
                       \     <img class="img-responsive ago" src="images/pe.jpg" alt="">
                            <p class="col-d">@Football22  Chris Larsen with the #CL22. #SlowpitchSunday @FootballSP  #beast</p>
                            <div class="clearfix"> </div>
                        </div>
                        <div class="regard-in">
                            <p><a href="#"> about a day ago we replied to </a></p>
                            <p>@danielcook1996  Hi Daniel, we are sorry that we can't get something out to you sooner. If you have any questions regarding...</p>
                            <a href="#"><span class="face"> </span></a>
                        </div>
                    </div>
                </div>
            </div>
            <!---->
        </div>
--}}
    </div>
@endsection
@section('footer')
    @if($profile)
        <script>
            $('#fav_btn').click(function(){
                $.ajax({
                    type: "POST",
                    url: "{{ route('futsal_fav_home',$futsal->slug) }}",
                }).success(function (data) {
                    $('#fav_btn').addClass(data.add)
                    $('#fav_btn').removeClass(data.remove)
                    new Noty({
                        type:data.status,
                        layout:"topRight",
                        text:data.message
                    }).show()
                })
            })
        </script>
    @endif
@endsection
</body>
</html>