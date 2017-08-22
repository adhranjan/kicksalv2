@extends('includes.adminDefault')
@section('header')
    <link href="{{ asset('assets/admin/vendors/single_image/single_image.css') }}" rel="stylesheet">
@endsection
@section('body_content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Edit Profile</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    {!! Form::model($profile,['route'=>['staff-profile.update',$profile->id],'method'=>'PUT','id'=>'demo-form2','class'=>'form-horizontal form-label-left','files' => true]) !!}
                    <div class="row">
                        <div class="col-md-8 col-lg-8 col-xs-12 col-sm-12">
                            <div class="form-group">
                                {{ Form::label('user_name', 'User Name', array('class' => 'control-label')) }}
                                {!! Form::text('user_name', null,['class'=>$errors->first('user_name')?'parsley-error form-control':''.'form-control','required'=>'required','id'=>'user_name','Placeholder'=>'User Name']) !!}
                                @if($errors->first('user_name'))
                                    <i class="red">{{ $errors->first('user_name') }}</i>
                                @endif
                            </div>
                            <div class="form-group">
                                {{ Form::label('phone', 'Phone', array('class' => 'control-label')) }}
                                {!! Form::text('phone', null,['class'=>$errors->first('phone')?'parsley-error form-control':''.'form-control','id'=>'phone','Placeholder'=>'Phone']) !!}
                                @if($errors->first('phone'))
                                    <i class="red">{{ $errors->first('phone') }}</i>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12">
                            <div class="panel-body collapse in" id="pro_collapse_member_image">
                                <!-- image -->
                                <label class="single_image form-group col-md-12 col-lg-12 @if($errors->has('image')) has-error @elseif(count($errors->all())>0) has-success @endif has-feedback" for="image_browse">
                                    <div class="input-group pro_make_full showToolTip" @if($errors->has('image')) title="{!!$errors->first('image')!!}" @endif>
                                        <span>Click here to select a image.</span>
                                        {!!Form::file('image', ['class'=>'form-control','id'=>'image_browse'])!!}
                                        @if($errors->has('image'))
                                            <br>
                                            <i class="red">{{ $errors->first('image') }}</i>
                                        @endif
                                    </div>
                                    <img src="{{ $profile->User->avatar_id }}?width=168" id="image_preview" alt=""/>
                                </label>
                            </div>
                            <div class="form-group">
                                <br>
                                {!! Form::radio('gender', 0,['class'=>$errors->first('gender')?'parsley-error form-control':''.'form-control','required'=>'required','id'=>'gender0']) !!} Female
                                {!! Form::radio('gender', 1,['class'=>$errors->first('gender')?'parsley-error form-control':''.'form-control','required'=>'required','id'=>'gender1']) !!} Male
                                @if($errors->first('gender'))
                                    <i class="red">{{ $errors->first('phone') }}</i>
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
    <script type="text/javascript" src="{{asset('assets/admin/vendors/single_image/single_image.js')}}"></script>
    <style>



    </style>
@endsection