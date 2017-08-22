@if(Auth::User()->staffProfile->relatedFutsal->timePrices->count()>0 && Auth::User()->staffProfile->relatedFutsal->grounds->count()>0)
    <li><a><i class="fa fa-newspaper-o"></i> Bookings <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a href="{{ route('my-bookings.index') }}">Lists</a></li>
            <li><a href="{{ route('my-bookings.create') }}">Offline Book</a></li>
        </ul>
    </li>

    @permission('my-futsal-bills')
    <li><a><i class="fa fa-money"></i> Bills<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a href="{{ route('my_futsal_bills') }}"> Lists </a></li>
            <li><a href="{{ route('my_futsal_bill_summary') }}"> Summary </a></li>
        </ul>
    </li>
    @endpermission
@endif
@permission('manage-my-futsal')
<li><a><i class="fa fa-cogs"></i> Futsal Setting <span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu">
        <li><a href="{{ route('time-price.create') }}"> Pricing</a></li>
        <li><a href="{{ route('setup_ground') }}"> Ground Setup</a></li>
        <li><a href="{{ route('my_futsal_users') }}">My Users</a></li>
        <li><a href="{{ route('create_my_user') }}">Create Users</a></li>
    </ul>
</li>
@endpermission
<li><a href="{{ route('staff-profile.show',Auth::User()->staffProfile->id) }}"><i class="fa fa-user"></i> My Profile</a></li>
