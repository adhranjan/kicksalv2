@extends('front.inlcudes.front_detault')
@section('body')
    <div class="content">
        <div class="content-top">
            <div class="container">
                <h3>Futsals</h3>
                @if($profile && $profile->favouriteFutsals->count()!=0)
                    <div class="content-slow">
                    <div class="slow-grid bat">
                        <h4>Favourite</h4>
                        <a class="view" href="#">VIEW ALL</a>
                    </div>
                    @foreach($profile->favouriteFutsals->chunk(2) as $favs)
                        <div class=" slow-grid grid-slow">
                        @foreach($favs as $fav)
                            <ul class="sign-in">
                                <li><img src="{{ $fav->avatar_id }}?width=100" class="img img-circle" alt=" "></li>
                                <li><a href="{{ route('futsal_detail_home',$fav->slug) }}">{{ $fav->name }}</a></li>
                            </ul>

                            @endforeach
                        </div>
                    @endforeach

                    <div class="clearfix"> </div>
                </div>
                @endif
                <div class="content-from row">
                    @foreach($futsals as $futsal)
                        <div class="col-md-4 from-grid ">
                            <img class="" src="{{ $futsal->avatar_id }}?width=200" alt=" " />
                            <p><a href="{{ route('futsal_detail_home',$futsal->slug) }}">{{ $futsal->name }}</a></p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
{{--
<div class="content">
    <div class="content-app-up">
        <div class="container">
            <span class="line"> </span>
            <h3>Trending from Social Media</h3>
            <div class="regard">
                <div class="regard-in">
                    <p><a href="#"> about a day ago we replied to </a></p>
                    <p>@danielcook1996 Hi Daniel, we are sorry that we can't get something out to you sooner. If you have any questions regarding...</p>
                    <a href="#"><span> </span></a>
                </div>
                <div class="regard-in">
                    <a href="#"><span class="camera"> </span></a>
                    <p><a href="#"> about a day ago we replied to </a></p>
                    <img class="img-responsive ago" src="images/pe.jpg" alt="">
                    <p class="col-d">@Football22 Chris Larsen with the #CL22. #SlowpitchSunday @FootballSP #beast</p>
                    <div class="clearfix"> </div>

                </div>
                <div class="regard-in">
                    <p><a href="#"> about a day ago we replied to </a></p>
                    <p>@danielcook1996 Hi Daniel, we are sorry that we can't get something out to you sooner. If you have any questions regarding...</p>
                    <a href="#"><span class="face"> </span></a>
                </div>


            </div>
        </div>
    </div>
    <!---->
</div>
--}}
@endsection
</body>
</html>