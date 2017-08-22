@extends('includes.adminDefault')
@section('header')
    <link href="{{ asset('assets/admin/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
@endsection
@section('body_content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                    <div class="x_title">
                        <h2>Player Summary<small>Activity report</small></h2>
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
                                    <img class="img-responsive avatar-view" src="{{ $player->avatar }}?width=220" alt="Avatar" title="Change the avatar">
                                </div>
                            </div>
                            <h3>{{ $player->user_name }}</h3>
                            <ul class="list-unstyled user_data">
                                <li><i class="fa fa-map-marker user-profile-icon"></i> {{ $player->address }}
                                </li>
                                <li>
                                    <i class="fa fa-user user-profile-icon"></i> {{ $player->gender }}
                                </li>

                                <li class="m-top-xs">
                                    <i class="fa fa-external-link user-profile-icon"></i>
                                    <a href="http://www.kimlabs.com/profile/" target="_blank">www.kimlabs.com</a>
                                </li>
                            </ul>
                            <br>

                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12">

                            <div class="profile_title">
                                <div class="col-md-6">
                                    <h2>User Activity Report</h2>
                                </div>
                                <div class="col-md-6">
                                    <div id="reportrange" class="pull-right" style="margin-top: 5px; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #E6E9ED">
                                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                        <span>June 23, 2017 - July 22, 2017</span> <b class="caret"></b>
                                    </div>
                                </div>
                            </div>


                            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Credit Management</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Projects Worked on</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Profile</a>
                                    </li>
                                </ul>
                                <div id="myTabContent" class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                        @php($totalCredit=0)
                                            {!! Form::open(['route'=>['futsal_bill',$player->id],'method'=>'POST','class'=>'form-horizontal form-label-left']) !!}
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Date</th>
                                                    <th>Total Amount</th>
                                                    <th>Remaining</th>
                                                    <th>Pay Now</th>
                                                    <th width="8%">Discount</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($unpaidBookings as $index=>$nonPaidBooking)
                                                    <tr>
                                                        <th scope="row">{{ $index+1 }}</th>
                                                        <td>{{ $nonPaidBooking->game_day }} ({{ date('l', strtotime($nonPaidBooking->game_day)) }}) </td>
                                                        <td>{{ ($nonPaidBooking->getBookingAmount()) }}</td>
                                                        <td>
                                                            @php($remainingArray=getTransactionDetailHtml($nonPaidBooking))
                                                            @php($totalCredit+=$remainingArray['remaining'])
                                                            <button type="button" class="btn btn-primary see_detail_transaction" title="Detail Transaction" data-target=".bs-example-modal-sm" data-html_text='{{ $remainingArray['html'] }}' style="width:65%">{{$remainingArray['remaining'] }}</button>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="bill_amt[{{ $nonPaidBooking->id }}]" class="form-control"  >
                                                        </td>
                                                        <td>
                                                            <input type="text" name="discount_amt[{{ $nonPaidBooking->id }}]" class="form-control" >
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                                <tfooter>
                                                    <tr>
                                                        <td colspan="3">Total Remaining</td>
                                                        <td>{{ $totalCredit }}</td>
                                                        <td>
                                                            @if($unpaidBookings->count()>0)
                                                                <button type="submit" class="btn btn-success">Submit</button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tfooter>
                                            </table>
                                            {!! Form::close() !!}
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                                        <!-- start user projects -->
                                        <table class="data table table-striped no-margin">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Project Name</th>
                                                <th>Client Company</th>
                                                <th class="hidden-phone">Hours Spent</th>
                                                <th>Contribution</th>
                                            </tr>
                                            </thead>
                                            {{--<tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>New Company Takeover Review</td>
                                                <td>Deveint Inc</td>
                                                <td class="hidden-phone">18</td>
                                                <td class="vertical-align-mid">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-success" data-transitiongoal="35" aria-valuenow="35" style="width: 35%;"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>New Partner Contracts Consultanci</td>
                                                <td>Deveint Inc</td>
                                                <td class="hidden-phone">13</td>
                                                <td class="vertical-align-mid">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-danger" data-transitiongoal="15" aria-valuenow="15" style="width: 15%;"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Partners and Inverstors report</td>
                                                <td>Deveint Inc</td>
                                                <td class="hidden-phone">30</td>
                                                <td class="vertical-align-mid">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-success" data-transitiongoal="45" aria-valuenow="45" style="width: 45%;"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>New Company Takeover Review</td>
                                                <td>Deveint Inc</td>
                                                <td class="hidden-phone">28</td>
                                                <td class="vertical-align-mid">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-success" data-transitiongoal="75" aria-valuenow="75" style="width: 75%;"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>--}}
                                        </table>
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
    <div class="modal fade bs-example-modal-sm" id="price_detail_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Payment Detail</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <ul style="list-style: none; padding-left: 0" id="modal_transaction_detail"></ul>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('footer')
    <script src="{{ asset('assets/admin/vendors/validator/validator.js') }}"></script>
    <script>
        $('.see_detail_transaction').click(function(){
            $('#modal_transaction_detail').html($(this).data('html_text'));
            $('#price_detail_modal').modal('show');
        })
    </script>

@endsection



