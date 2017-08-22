@extends('includes.adminDefault')
@section('header')
    {{--
        <link href="{{ asset('assets/admin/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
    --}}
    <link href="{{ asset('assets/admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">


@endsection

@section('body_content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_content">
                <div class="well" style="overflow: auto">
                    <div class="col-md-4">
                        <div id="reportrange_right" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                            <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                        </div>
                    </div>
                    <div class="col-md-4 pull-right">
                            Total {{ $total_games }} game(s).<small>{{ $period }}</small>
                    </div>
                </div>
                <table id="datatable-checkbox" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th colspan="3" class="text-center">Sales Summary</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <strong>
                                    Particulars
                                </strong>
                            </td>
                            <td>
                                <strong>Dr.</strong>
                            </td>
                            <td>
                                <strong>Cr.</strong>
                            </td>
                        </tr>
                        <tr class="warning">
                            <td>Sales</td>
                            <td>{{ $total_price }}</td>
                            <td></td>
                        </tr>
                        <tr class="warning">
                            <td>Total Discount</td>
                            <td>-{{ $total_discount }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Total Receivable (Discounted)</td>
                            <td>{{ $total_receivable }}</td>
                        </tr>
                        <tr>
                            <td>Total Received</td>
                            <td>{{ $total_received }}</td>
                        </tr>
                        <tr>
                            <td>Total Credit</td>
                            <td>{{ $total_remaining }}</td>
                        </tr>
                    </tbody>
                </table>

                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Sales Summary <small>{{ $period }}</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content1">
                            <div id="graph_bar_group" style="width:100%; height:280px;"></div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <form action="{{ route('my_futsal_bill_summary') }}" method="get" id="my_futsal_bills">
        <input type="hidden" name="ds_">
        <input type="hidden" name="de_">
    </form>
@endsection

@section('footer')
    <script src="{{ asset('assets/admin/vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <script src="{{ asset('assets/admin/vendors/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendors/morris.js/morris.min.js') }}"></script>


    <script>

        $( document ).ready(function() {
            var start='';
            var end='';
            $("#reportrange_right").on("apply.daterangepicker",function(a,b){
                start=b.startDate.format("YYYY-MM-DD")
                end=b.endDate.format("YYYY-MM-DD")
                $("[name='ds_']").attr('value',start);
                $("[name='de_']").attr('value',end);
                $('#my_futsal_bills').submit();
            }
        )

            $("#graph_bar_group").length && Morris.Bar({
                element: "graph_bar_group",
                data: [{period: "{{ $period }}", sales: {{$total_price}}, total_discount: {{ $total_discount }},total_receivable: {{ $total_receivable}},total_received: {{ $total_received }},total_remaining:{{ $total_remaining }} }],
                xkey: "period",
                barColors: ["#03586A", "#f0ad4e", "#3498DB", "#26B99A","#d9534f"],
                ykeys: ["sales", "total_discount","total_receivable","total_received","total_remaining"],
                labels: ["Sales", "Discount","Receivable(Discounted)","Received","Credit"],
                hideHover: "auto",
                xLabelAngle: 60,
                resize: !0
            })
        });

    </script>



@endsection
