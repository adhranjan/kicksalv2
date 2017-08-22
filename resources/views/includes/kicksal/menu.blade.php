@permission('manage-futsal')
    <li><a><i class="fa fa-newspaper-o"></i> Futsal <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a href="{{ route('futsal.index') }}">All Futsals</a></li>
            <li><a href="{{ route('futsal.create') }}">Create Futsal</a></li>
        </ul>
    </li>
@endpermission
