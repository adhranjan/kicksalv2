<?php
namespace App\Http\Controllers\Api;


use App\Futsal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiFutsalController extends Controller
{

    protected $user;
    protected $profile;
    protected $futsal;

    public function index(Futsal $futsal,Request $request)
    {
        $futsal = $futsal->has('grounds')->has('timePrices');
        if($request->has('favourite')){
            $futsal=$this->profile->favouriteFutsals();
        }
        $futsal=$futsal->paginate(1);
        return response()->json($futsal,200);

    }

    public function futsal(Futsal $futsal, Request $request)
    {
        $bookings=$futsal->bookings()->with('bookedForGround');

        if($request->has('game_day')){
            $bookings=$bookings->whereGameDay($request->game_day);
        }
        if($request->has('game_after')){
            $bookings=$bookings->where('game_day','>=',$request->game_after);
        }
        if($request->has('game_before')){
            $bookings=$bookings->where('game_day','<=',$request->game_before);
        }

        $mybook=clone($bookings);
        $data['my_bookings']=array();
        $data['is_favourite']=null;
        if($this->profile){
            $data['my_bookings']=$mybook->wherePlayer_id($request->user()->playerProfile->id)->get();
            $data['is_favourite']=$this->profile->favouriteFutsals()->find($futsal->id)?true:false;
        }
        $data['bookings']=$bookings->get();
        $data['grounds']=$futsal->grounds;
        return response()->json($data,200);
    }

    public function favouriteMaker($futsal,Request $request)
    {
        $favourite=$this->profile->favouriteFutsals()->find($futsal->id);
        if(!$favourite){
            $this->profile->favouriteFutsals()->attach([$futsal->id]);
            $data{'message'}='Added To Favourite List.';
        }else{
            $this->profile->favouriteFutsals()->detach([$futsal->id]);
            $data{'message'}='Removed From Favourite List.';
        }
        $data{'status'}='success';
        return response()->json($data,200);

    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user=$request->user();
            $this->profile= $this->user->playerProfile?$this->user->playerProfile:false;
            return $next($request);
        });
    }


    }
