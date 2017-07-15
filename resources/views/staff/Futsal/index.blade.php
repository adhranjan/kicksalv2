@extends('includes.adminDefault')
@section('header')
    <link href="{{ asset('assets/admin/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('body_content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($futsals as $index=>$futsal)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $futsal->name }}</td>
                        <td>{{ $futsal->address }}</td>
                        <td>{{ $futsal->telephone }}</td>
                        <td><a href="{{ route('futsal.edit',$futsal->slug) }}"><i class="fa fa-edit"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $futsals->links() }}
        </div>
    </div>
@endsection

@section('footer')

    <script src="{{ asset('assets/admin/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendors/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('assets/admin/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script>


    </script>

@endsection
