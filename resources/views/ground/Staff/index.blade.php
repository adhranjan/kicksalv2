@extends('includes.adminDefault')
@section('header')
    <link href="{{ asset('assets/admin/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endsection
@section('body_content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <table class="table table-striped table-bordered bulk_action">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($staffs as $index=>$staff)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $staff->User->name }}</td>
                        <td>{{ $staff->User->hasRole('futsal_owners')?'Owner/Partner':'Staff'}}</td>
                        <td><a href="{{ route('my_user_edit',$staff->User->id) }}"><i class="fa fa-edit"></i></a>
                            <a href="{{ route('staff-profile.show',$staff->id) }}"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $staffs->links() }}
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{ asset('assets/admin/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>

@endsection
