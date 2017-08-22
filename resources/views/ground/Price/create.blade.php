@extends('includes.adminDefault')
@section('header')
    <link href="{{ asset('assets/admin/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
@endsection
@section('body_content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Time Price Setup</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    {!! Form::open(['route'=>'time-price.store','method'=>'POST','novalidate','data-parsley-validate' ,'id'=>'demo-form2','class'=>'form-horizontal form-label-left']) !!}
                    <div class="row">
                        @php($count=0)
                        @foreach($week_days as $week_day)
                            <div class="col-md-12">
                                <h3>{{ $week_day->day }}</h3>
                            </div>
                                @foreach($booking_times as $index=>$booking_time)
                                    @php($day_period_time=clone($time_prices))
                                    @php($price=$day_period_time->whereTimeId($booking_time->id)->whereDayId($week_day->id))
                                    @php($priceObject=$price->whereBatch($price->max('batch'))->first())
                                    <div class="col-md-2 col-lg-2 col-xs-2 col-sm-2">
                                        <div class="form-group">
                                            <small>{{ Form::label('time_price', $booking_time->start_time.' : '.$booking_time->end_time, array('class' => 'control-label')) }}</small>
                                            {!! Form::text('time_price['.$week_day->id.']['.$booking_time->id.']',$priceObject?$priceObject->price:null ,['class'=>$errors->first('time_price')?'parsley-error form-control time_price':''.'form-control time_price','Placeholder'=>$booking_time->start_time.' : '.$booking_time->end_time]) !!}
                                            @if($errors->first('time_price'))
                                                <i class="red">{{ $errors->first('time_price') }}</i>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            <div class="clearfix"></div>
                        @endforeach
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <button type="reset" class="btn btn-primary">Cancel</button>
                            <button type="submit" class="btn btn-success">Submit</button>
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
        var price='';
        $(".time_price").change(function(){
            price=$(this).val();
        });

        $( ".time_price" ).focus(function() {
            if(price!=''){
                $(this).val(price);
            }
        });


    </script>
@endsection