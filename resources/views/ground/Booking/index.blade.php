@extends('includes.adminDefault')
@section('header')
    <link href="{{ asset('assets/admin/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('body_content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <table id="datatable-checkbox" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Time</th>
                    <th>Date</th>
                    <th>User</th>
                    <th>Phone</th>
                    <th>Ground</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($bookings as $index=>$booking)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ ($booking->book_time)}}</td>
                        <td>{{ ($booking->game_day)}}</td>
                        <td><a href="{{ route('get_player_detail_with_id',$booking->bookedByPlayer->id) }}">{{ ($booking->bookedByPlayer->user_name)}}</a></td>
                        <td><a href="{{ route('get_player_detail_with_id',$booking->bookedByPlayer->id) }}">{{ ($booking->bookedByPlayer->phone)}}</a></td>
                        <td>{{ ($booking->bookedForGround->name)}}</td>
                        <td>{{ ($booking->status)}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $bookings->links() }}
        </div>
    </div>
@endsection

@section('footer')

    <script src="{{ asset('assets/admin/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>

@endsection
