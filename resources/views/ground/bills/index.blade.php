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
                        <th>#</th>
                        <th>Game Date</th>
                        <th>Game Time</th>
                        <th>Comitted By</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Receivable</th>
                        <th>Received</th>
                        <th>Remaining</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($totalPrice=0)
                    @php($totalDiscount=0)
                    @php($totalReceivable=0)
                    @php($totalReceived=0)
                    @php($totalRemaining=0)
                    @foreach($bookings as $index=>$booking)
                        <tr class={{ $booking->getBookingCollection() == $booking->getBookingAmount()?'':'danger' }}>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $booking->game_day  }}</td>
                            <td>{{ $booking->book_time }}</td>
                            <td>{{ $booking->commit_by }}</td>
                            <td>
                                @php($price=$booking->getBookingAmount())
                                @php($totalPrice+=$price)
                                {{  $price  }}
                            </td>
                            <td>
                                @php($discount=$booking->getBookingDiscount())
                                @php($totalDiscount+=$discount)
                                {{ $discount }}
                            </td>
                            <td>
                                @php($receivable=$booking->getBookingAmount()-$booking->getBookingDiscount())
                                @php($totalReceivable+=$receivable)
                                {{ $receivable }}
                            </td>
                            <td>
                                @php($received=$booking->getBookingCollectionNoDiscount())
                                @php($totalReceived+=$received)
                                {{ $received }}
                            </td>
                            <td>
                                @php($remaining=$receivable-$received)
                                @php($totalRemaining+=$remaining)
                                {{ $remaining }}
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" class="text-center">Total</td>
                        <td>{{ $totalPrice }}</td>
                        <td>{{ $totalDiscount }}</td>
                        <td>{{ $totalReceivable }}</td>
                        <td>{{ $totalReceived }}</td>
                        <td>{{ $totalRemaining}}</td>
                    </tr>
                    </tbody>
                </table>
                {!! $bookings->appends(request()->input())->links() !!}
            </div>
        </div>
    </div>
    <form action="{{ route('my_futsal_bills') }}" method="get" id="my_futsal_bills">
        <input type="hidden" name="ds_">
        <input type="hidden" name="de_">
    </form>
@endsection

@section('footer')
    <script src="{{ asset('assets/admin/vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>


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

        });

    </script>



@endsection
