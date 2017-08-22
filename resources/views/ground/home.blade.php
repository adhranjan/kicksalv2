@extends('includes.adminDefault')
<link href="{{ asset('assets/admin/vendors/single_image/single_image.css') }}" rel="stylesheet">
@section('body_content')
    <div class="row tile_count">
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
        <div class="count">2500</div>
        <span class="count_bottom"><i class="green">4% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-clock-o"></i> Average Time</span>
        <div class="count">123.50</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Males</span>
        <div class="count green">2,500</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Females</span>
        <div class="count">4,567</div>
        <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Collections</span>
        <div class="count">2,315</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Connections</span>
        <div class="count">7,325</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
    </div>
</div>
    <div class="row">
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Futsal <small>Logo</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="dashboard-widget-content">
                    <div class="panel-body collapse in" id="pro_collapse_member_image">
                        @if(Auth::User()->can('manage-my-futsal'))
                            {!! Form::open(['route'=>'change_futsal_display_picture','method'=>'POST','class'=>'form-horizontal form-label-left','id'=>'change_futsal_display_picture','files' => true]) !!}
                            <label class="single_image col-md-12 col-lg-12 @if($errors->has('image')) has-error @elseif(count($errors->all())>0) has-success @endif has-feedback" for="image_browse">

                                    {!!Form::file('image', ['class'=>'form-control','id'=>'image_browse'])!!}
                                    @if($errors->has('image'))
                                        <br>
                                        <i class="red">{{ $errors->first('image') }}</i>
                                    @endif
                                <img src="{{ Auth::User()->staffProfile->relatedFutsal->avatar_id}}?width=154" id="image_preview" alt=""/>
                            </label>
                        {!! Form::close() !!}

                        @else

                        @endif
                        <!-- image -->
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-sm-8 col-xs-12">
        @role('futsal_admin')
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Find Your Futsal</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="dashboard-widget-content">
                            <div class="form-group input-group @if(count($errors->all())>0){{($errors->has('coordinates'))?'has-error':'has-success'}}@endif col-lg-12 col-md-12">
                                @if($errors->has('coordinates'))
                                    <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true"></span>
                                    <p class="help-block">{{$errors->first('coordinates')}}</p>
                                @elseif(count($errors->all())>0)
                                    <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
                                @endif
                            </div>
                            @if(Auth::User()->can('manage-my-futsal'))
                                <div id='map' class='mapCooL' style="width:100%; height:370px;"></div>
                                {!! Form::open(['route'=>'change_futsal_coordinates','method'=>'POST','class'=>'form-horizontal form-label-left','id'=>'change_futsal_display_picture','files' => true]) !!}
                                   <input id="pac-input" class="controls" type="text" placeholder="Search Place">
                                    <input type='hidden' size='38' maxlength='40' name='coordinates' id='coordinates' class="form-control" value="{!! Auth::USer()->staffProfile->relatedFutsal->map_coordinates !!}" />
                                        <br>
                                    <button class="pull-right btn btn-success" type="Submit">Change</button>
                                    <div class="clearfix"></div>
                                {!! Form::close() !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endrole
        <div class="row">
            <!-- Start to do list -->
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="col-md-4 hidden-small">
                            <table class="countries_list">
                                <tbody>
                                @foreach( Auth::User()->staffProfile->relatedFutsal->paymentGateways as $paymentGateway)
                                    <tr>
                                        <td>{{ $paymentGateway->name }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <h2>To Do List <small>Sample tasks</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Settings 1</a>
                                    </li>
                                    <li><a href="#">Settings 2</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="">
                            <ul class="to_do">
                                <li>
                                    <p>
                                        <input type="checkbox" class="flat"> Schedule meeting with new client </p>
                                </li>
                                <li>
                                    <p>
                                        <input type="checkbox" class="flat"> Create email address for new intern</p>
                                </li>
                                <li>
                                    <p>
                                        <input type="checkbox" class="flat"> Have IT fix the network printer</p>
                                </li>
                                <li>
                                    <p>
                                        <input type="checkbox" class="flat"> Copy backups to offsite location</p>
                                </li>
                                <li>
                                    <p>
                                        <input type="checkbox" class="flat"> Food truck fixie locavors mcsweeney</p>
                                </li>
                                <li>
                                    <p>
                                        <input type="checkbox" class="flat"> Food truck fixie locavors mcsweeney</p>
                                </li>
                                <li>
                                    <p>
                                        <input type="checkbox" class="flat"> Create email address for new intern</p>
                                </li>
                                <li>
                                    <p>
                                        <input type="checkbox" class="flat"> Have IT fix the network printer</p>
                                </li>
                                <li>
                                    <p>
                                        <input type="checkbox" class="flat"> Copy backups to offsite location</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End to do list -->

            <!-- start of weather widget -->
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Daily active users <small>Sessions</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Settings 1</a>
                                    </li>
                                    <li><a href="#">Settings 2</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="temperature"><b>Monday</b>, 07:30 AM
                                    <span>F</span>
                                    <span><b>C</b></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="weather-icon">
                                    <canvas height="84" width="84" id="partly-cloudy-day"></canvas>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="weather-text">
                                    <h2>Texas <br><i>Partly Cloudy Day</i></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="weather-text pull-right">
                                <h3 class="degrees">23</h3>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="row weather-days">
                            <div class="col-sm-2">
                                <div class="daily-weather">
                                    <h2 class="day">Mon</h2>
                                    <h3 class="degrees">25</h3>
                                    <canvas id="clear-day" width="32" height="32"></canvas>
                                    <h5>15 <i>km/h</i></h5>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="daily-weather">
                                    <h2 class="day">Tue</h2>
                                    <h3 class="degrees">25</h3>
                                    <canvas height="32" width="32" id="rain"></canvas>
                                    <h5>12 <i>km/h</i></h5>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="daily-weather">
                                    <h2 class="day">Wed</h2>
                                    <h3 class="degrees">27</h3>
                                    <canvas height="32" width="32" id="snow"></canvas>
                                    <h5>14 <i>km/h</i></h5>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="daily-weather">
                                    <h2 class="day">Thu</h2>
                                    <h3 class="degrees">28</h3>
                                    <canvas height="32" width="32" id="sleet"></canvas>
                                    <h5>15 <i>km/h</i></h5>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="daily-weather">
                                    <h2 class="day">Fri</h2>
                                    <h3 class="degrees">28</h3>
                                    <canvas height="32" width="32" id="wind"></canvas>
                                    <h5>11 <i>km/h</i></h5>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="daily-weather">
                                    <h2 class="day">Sat</h2>
                                    <h3 class="degrees">26</h3>
                                    <canvas height="32" width="32" id="cloudy"></canvas>
                                    <h5>10 <i>km/h</i></h5>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end of weather widget -->
        </div>
    </div>
</div>
@endsection

@section('footer')
    <script type="text/javascript" src="{{asset('assets/admin/vendors/single_image/single_image.js')}}"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChgJjjrSLRJVmLWL8d3nQtvIscekfI_-s&libraries=places"></script>
    <script type="text/javascript" src="{{asset('assets/admin/vendors/googlemap/js/google_map.js')}}"></script>
    <script>
        $( document ).ready(function() {
            @if(Auth::User()->can('manage-my-futsal'))
                $('#image_browse').on('change',function(){
                    $('#change_futsal_display_picture').submit()
                })
            @endif

        });
    </script>

@endsection