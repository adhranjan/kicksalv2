@extends('front.inlcudes.front_detault')
@section('body')
    <div class="content register_min">
        <div class="content-top">
            <div class="container">
                   <div class="content-slow">
                    <div class="slow-grid bat">
                        <h4>{{ $query }}</h4>
                    </div>
                    @foreach($results->chunk(2) as $futsal)
                        <div class=" slow-grid grid-slow">
                        @foreach($futsal as $futsal)
                            <ul class="sign-in">
                                <li><img src="{{ $futsal->avatar_id }}?width=100" class="img img-circle" alt=" "></li>
                                <li><a href="{{ route('futsal_detail_home',$futsal->slug) }}">{{ $futsal->name }}</a></li>
                            </ul>
                            @endforeach
                        </div>
                    @endforeach
                    @if($results->count()==0)
                           <h2 class="text-center"> No results :(</h2>
                            <p>Search other futsals with some other keyword.</p>
                    @endif
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
</body>
</html>