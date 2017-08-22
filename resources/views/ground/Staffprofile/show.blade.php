@extends('includes.adminDefault')
@section('header')

@endsection
@section('body_content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                    <div class="x_title">
                        <h2>Profile<small>Activity report</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                            <div class="profile_img">
                                <div id="crop-avatar">
                                    <!-- Current avatar -->
                                    <img class="img-responsive avatar-view" src="{{ $profile->User->avatar_id }}" alt="Avatar" title="Change the avatar">
                                </div>
                            </div>
                            <h3>{{ $profile->user_name }}</h3>
                            <ul class="list-unstyled user_data">
                                @if($profile->phone)<li><i class="fa fa-phone"></i> {{ $profile->phone }}</li> @endif
                                <li>
                                    <i class="fa fa-briefcase user-profile-icon"></i> {{$profile->relatedFutsal->name}}
                                </li>
                                <li class="m-top-xs">
                                    <i class="fa fa-external-link user-profile-icon"></i>
                                    <a href="http://www.kimlabs.com/profile/" target="_blank">www.kimlabs.com</a>
                                </li>
                            </ul>
                            @if($profile->id == Auth::User()->staffProfile->id)
                                <a href="{{ route('staff-profile.edit',$profile->id) }}" class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a>
                            @endif
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="profile_title">
                                <div class="col-md-6">
                                    <h2>User Activity Report</h2>
                                </div>
                            </div>
                            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">{{ $profile->user_name }}'s Sales</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Projects Worked on</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Profile</a>
                                    </li>
                                </ul>
                                <div id="myTabContent" class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                            <div class="x_panel">
                                                <div class="x_title">
                                                    <h2>Sales<small>Chart</small></h2>
                                                    <ul class="nav navbar-right panel_toolbox">

                                                    </ul>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="x_content">
                                                    <canvas id="mybarChart"></canvas>
                                                </div>
                                            </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                                        <!-- start user projects -->

                                        <!-- end user projects -->
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                                        <p>xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui
                                            photo booth letterpress, commodo enim craft beer mlkshk </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="{{ asset('assets/admin/vendors/Chart.js/dist/Chart.min.js') }}"></script>
@endsection
@section('below_footer')

    <script>
        $( document ).ready(function() {
            var f = document.getElementById("mybarChart");
            new Chart(f, {
                type: "bar",
                data: {
                    labels:{!! json_encode($months) !!},
                    datasets: [{
                        label: "Sales Amount",
                        backgroundColor: "#26B99A",
                        data: {!! json_encode(array_values($sales_amount)) !!}
                    }, {label: "Cash Collection", backgroundColor: "#03586A", data: {!! json_encode(array_values($collected_amount)) !!}},
                        {label: "Discounts", backgroundColor: "#f0ad4e", data: {!! json_encode(array_values($discount_amount)) !!}},
                        {label: "Not Collected", backgroundColor: "#d9534f", data: {!! json_encode(array_values($collection_remaining_amount)) !!}}

                    ]
                },
                options: {scales: {yAxes: [{ticks: {beginAtZero: !0}}]}}
            })
        });
    </script>
@endsection



