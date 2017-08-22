<div class="header">
    <div class="header-top">
        <div class="container">
            <p class="header-para">
                @include('front.inlcudes.header_form')
            </p>
            <ul class="sign">
                <li>
                    <a class="" href="{{ route('logout') }}?cya=g"
                       onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </ul>
        </div>
        <div class="clearfix"> </div>
    </div>
    <div class="header-bottom-top">
        <div class="container">
            {!! Form::open(['route'=>['futsal_search'],'method'=>'GET']) !!}
            <div class="search">
                <input type="text" name="q"  value="{{ isset($_GET['q'])?$_GET['q']:''}} " required="required" placeholder="Search Futsals" >
                <input type="submit"  value="">
            </div>
            {!! Form::close() !!}


            <div class="clearfix"> </div>
            <div class="header-bottom">
                <div class="top-nav">
                    <span class="menu caret"></span>
                    <ul>
                        <li class="active" ><a href="{{ route('users_home') }}" class="scroll">Home</a></li>
                        @if($profile)
                            <li><a href="{{ route('player_front_profile') }}" class="scroll">Profile</a></li>
                            <li><a href="#" class="scroll">Team</a></li>
                        @endif
                        <li><a href="#" class="scroll">Services</a></li>
                        <li><a href="#" class="scroll">Sports </a></li>
                        <li><a href="#" class="scroll">Contact</a></li>
                    </ul>
                    <!--script-->
                    <script>
                        $("span.menu").click(function(){
                            $(".top-nav ul").slideToggle(500, function(){
                            });
                        });
                    </script>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
</div>
