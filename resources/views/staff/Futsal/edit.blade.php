@extends('includes.adminDefault')
@section('header')
@endsection
@section('body_content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Edit Futsal</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    {!! Form::model($futsal,['route'=>['futsal.update',$futsal->slug],'method'=>'PUT','novalidate','data-parsley-validate' ,'id'=>'demo-form2','class'=>'form-horizontal form-label-left','files' => true]) !!}
                    <div class="row">
                        <div class="col-md-8 col-lg-8 col-xs-12 col-sm-12">
                            <div class="form-group">
                                {{ Form::label('name', 'Futsal Name', array('class' => 'control-label')) }}
                                {!! Form::text('name', null,['class'=>$errors->first('name')?'parsley-error form-control':''.'form-control','required'=>'required','id'=>'name','Placeholder'=>'Name']) !!}
                                @if($errors->first('name'))
                                    <i class="red">{{ $errors->first('name') }}</i>
                                @endif
                            </div>
                            <div class="form-group">
                                {{ Form::label('admin', 'Admin Name', array('class' => 'control-label')) }}
                                {!! Form::text('admin', $futsal->admin()->name,['class'=>$errors->first('admin')?'parsley-error form-control':''.'form-control','required'=>'required','id'=>'admin','Placeholder'=>'Admin Name']) !!}
                                @if($errors->first('admin'))
                                    <i class="red">{{ $errors->first('admin') }}</i>
                                @endif
                            </div>
                            <div class="form-group">
                                {{ Form::label('email', 'Admin Email', array('class' => 'control-label')) }}
                                {!! Form::text('email', $futsal->admin()->email,['class'=>$errors->first('email')?'parsley-error form-control':''.'form-control','required'=>'required','id'=>'email','Placeholder'=>'Admin Email']) !!}
                                @if($errors->first('email'))
                                    <i class="red">{{ $errors->first('email') }}</i>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12">
                            <div class="form-group">
                                {{ Form::label('payment_gateway', 'Payment Models', array('class' => 'control-label')) }}
                                {!! Form::select('payment_gateway[]', $payment_gateways, $futsal->paymentGateways,['class'=>$errors->first('payment_gateway')?'parsley-error form-control':''.'form-control','id'=>'payment_gateway','Placeholder'=>'Payment gateway','multiple']) !!}
                                @if($errors->first('payment_gateway'))
                                    <i class="red">{{ $errors->first('payment_gateway') }}</i>
                                @endif
                            </div>
                            <div class="form-group">
                                {{ Form::label('book_via_app', 'Book Via App?', array('class' => 'control-label')) }}
                                <input type="checkbox" class="flat" name="book_via_app" value="1" @if($futsal->book_via_app=='Can Book' )checked @endif>
                                @if($errors->first('book_via_app'))
                                    <i class="red">{{ $errors->first('book_via_app') }}</i>
                                @endif
                            </div>
                            <div class="clearfix"></div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <button type="reset" class="btn btn-primary">Cancel</button>
                                <button type="submit" class="btn btn-success">Submit</button>
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




@endsection