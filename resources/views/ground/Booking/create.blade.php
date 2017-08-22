@extends('includes.adminDefault')
@section('header')
    <link href="{{ asset('assets/admin/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet" />
@endsection
@section('body_content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Book A Game</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    {!! Form::open(['route'=>'my-bookings.store','method'=>'POST','class'=>'form-horizontal form-label-left','files' => true]) !!}
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                            <div class="form-group">
                                {{ Form::label('phone', 'Phone', array('class' => 'control-label')) }}
                                {!! Form::text('phone', null,['class'=>$errors->first('phone')?'parsley-error form-control':''.'form-control','required'=>'required','id'=>'phone','Placeholder'=>'Phone Number',"autofocus"=>"autofocus"]) !!}
                                <i id="phone_error" class="red"></i>
                            </div>
                            <input type="hidden" name="player_id" id="player_id">

                            <div class="form-group">
                                {{ Form::label('ground_id', 'Ground', array('class' => 'control-label')) }}
                                {!! Form::select('ground_id',$ground_id, null,['class'=>$errors->first('ground_id')?'parsley-error form-control':''.'form-control','required'=>'required','id'=>'ground_id']) !!}
                                @if($errors->first('ground_id'))
                                    <i class="red">{{ $errors->first('book_time') }}</i>
                                @endif
                            </div>
                            <div class="form-group">
                                {{ Form::label('book_time', 'Booking Time', array('class' => 'control-label')) }}
                                {!! Form::select('book_time',$book_time, null,['class'=>$errors->first('book_time')?'parsley-error form-control':''.'form-control','required'=>'required','id'=>'book_time']) !!}
                                @if($errors->first('book_time'))
                                    <i class="red">{{ $errors->first('book_time') }}</i>
                                @endif
                            </div>
                            <div class="form-group">
                                {{ Form::label('game_day', 'Game Day', array('class' => 'control-label')) }}
                                {!! Form::date('game_day', null,['class'=>$errors->first('game_day')?'parsley-error form-control':''.'form-control','required'=>'required','id'=>'game_day','Placeholder'=>'Game Day']) !!}
                                @if($errors->first('game_day'))
                                    <i class="red">{{ $errors->first('game_day') }}</i>
                                @endif
                            </div>
                            <div class="clearfix"></div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <button type="reset" class="btn btn-primary">Cancel</button>
                                <button type="submit" disabled="disabled" id="submit_booking" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                            <div class="x_content player_detail" style="display:none">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="weather-icon">
                                            <img id="avatar" src="" alt="">
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="weather-text">
                                            <h2 id="name"></h2>
                                            <p id="other_detail"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row weather-days">
                                    <div class="col-sm-2">
                                        <div class="daily-weather">
                                            <h2 class="day">Total</h2>
                                            <h3 id ="total" class="text-center"></h3>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="daily-weather">
                                            <h2 class="day">Accepted</h2>
                                            <h3 id ="accepted" class="text-center"></h3>

                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="daily-weather">
                                            <h2 class="day">Rejected</h2>
                                            <h3 id="rejected" class="text-center"></h3>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="daily-weather">
                                            <h2 class="day">Cancelled</h2>
                                            <h3 id="cancelled" class="text-center"></h3>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="daily-weather">
                                            <h2 class="day">Paybale</h2>
                                            <h3 id="credit_in_my_futsal" class="text-center"></h3>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="daily-weather">
                                            <h2 class="day">Played</h2>
                                            <h3 id="games_in_my_futsal" class="text-center"></h3>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @endsection
@section('footer')
    <script>
        var phone='';
        var player_id='';
        var name='';
        var total='';
        var cancelled='';
        var rejected='';
        var accepted='';
        var avatar='';
        var games_in_my_futsal='';
        var credit_in_my_futsal='';
        var other_detail='';
        $('#phone').focusout(function(){
                phone=this.value;
                getUserDetails(phone);
        });



        function getUserDetails($phone){
            var data={'phone': $phone}
            $.ajax({
                type: "GET",
                url: "{{ route('get_player_detail_with_number') }}",
                data:data,
            }).success(function (data) {
                $('#submit_booking').removeAttr('disabled');
                $('#phone_error').html('')
                showPlayerDetail(data);
            }).error(function (jqXHR, textStatus, errorThrown) {
                $('#phone_error').html($.parseJSON(jqXHR.responseText).phone[0])
                $('#submit_booking').attr('disabled','disabled');
            })

        }



        function showPlayerDetail(data) {
            console.log(data);
            data=$.parseJSON(data);
            $('.player_detail').show();
            player_id=data.player_id;
            name=data.name;
            total=data.total;
            accepted=data.accepted;
            rejected=data.rejected;
            games_in_my_futsal=data.games_in_my_futsal;
            cancelled=data.cancelled;
            credit_in_my_futsal=data.credit_in_my_futsal;
            other_detail=data.other_detail;
            avatar=data.avatar+'?width=100';
            $('#player_id').val(player_id);
            $('#name').html(name);
            $('#avatar').attr('src',avatar);
            $('#total').html(total);
            $('#rejected').html(rejected);
            $('#cancelled').html(cancelled);

            $('#accepted').html(accepted);
            $('#games_in_my_futsal').html(games_in_my_futsal);
            $('#credit_in_my_futsal').html(credit_in_my_futsal);
            $('#other_detail').html(other_detail);
        }

    </script>

@endsection