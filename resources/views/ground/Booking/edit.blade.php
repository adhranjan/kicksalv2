@extends('includes.adminDefault')
@section('header')
    <link href="{{ asset('assets/admin/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
@endsection
@section('body_content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Edit User</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    {!! Form::model($user,['route'=>['my_user_edit_post',$user->id],'method'=>'PUT','novalidate','data-parsley-validate' ,'id'=>'demo-form2','class'=>'form-horizontal form-label-left','files' => true]) !!}
                    <div class="row">
                        <div class="col-md-8 col-lg-8 col-xs-12 col-sm-12">
                            <div class="form-group">
                                {{ Form::label('name', 'User Name', array('class' => 'control-label')) }}
                                {!! Form::text('name', null,['class'=>$errors->first('name')?'parsley-error form-control':''.'form-control','required'=>'required','id'=>'name','Placeholder'=>'User Name']) !!}
                                @if($errors->first('name'))
                                    <i class="red">{{ $errors->first('name') }}</i>
                                @endif
                            </div>
                            <div class="form-group">
                                {{ Form::label('email', 'User Email', array('class' => 'control-label')) }}
                                {!! Form::text('email', null,['class'=>$errors->first('email')?'parsley-error form-control':''.'form-control','required'=>'required','id'=>'email','Placeholder'=>'User Email']) !!}
                                @if($errors->first('email'))
                                    <i class="red">{{ $errors->first('email') }}</i>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12">
                            <div class="form-group">
                                {{ Form::label('is_owner', 'Is Owner?', array('class' => 'control-label')) }}
                                <input type="checkbox" value="1" class="flat" name="is_owner" @if($user->hasRole('futsal_owners')) checked @endif>
                                @if($errors->first('is_owner'))
                                    <i class="red">{{ $errors->first('is_owner') }}</i>
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