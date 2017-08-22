<?php

namespace App\Http\Controllers;

use App\BookTime;
use App\Futsal;

use App\Http\Helpers\HelperTraits;
use App\Http\Requests\CreateBookingRequest;
use App\Http\Requests\GetPlayerProfileRequest;
use App\Http\Requests\SearchRequest;
use App\PlayerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{

    use HelperTraits;
    protected $folder='front';

    protected $futsal;
    protected $kicksalData;
    protected $user;
    protected $profile;

    public function index(Futsal $futsal)
    {
        $this->kicksalData['futsals']= $futsal->has('grounds')->has('timePrices')->get();
        return view($this->folder.'.index',$this->kicksalData);
    }

    public function futsal($futsal)
    {
        $this->kicksalData['futsal']= $futsal;
        $this->kicksalData['ground_id']= $futsal->grounds()->pluck('name','id');
        $this->kicksalData['book_time']=BookTime::pluck('start_time','id');
        $this->kicksalData['bookings']= $futsal->bookings()->where('game_day','<=',date("Y-m-d", strtotime("+1 week")))->where('game_day','>=',date("Y-m-d"))->orderBy('game_day','asc')->get();
        if($this->profile){
            $this->kicksalData['myBookings']= $this->profile->bookings()->whereIn('ground_id',$futsal->grounds()->pluck('id')->toArray())->where('game_day','>=',date("Y-m-d"))->orderBy('game_day','asc')->get();
        }

        $this->kicksalData['title']= $futsal->name;
        return view($this->folder.'.futsal_detail',$this->kicksalData);
    }

    public function book($futsal,CreateBookingRequest $request)
    {
        $time_price=$futsal->timePrices()->whereTimeId($request->book_time)->whereDayId(dayToWeekDay($request->game_day)->id);
        $max_batch=$time_price->max('batch');
        $futsal->grounds()->find($request->ground_id)->bookings()->create([
            'book_time'=>$request->book_time,
            'player_id'=>$this->profile->id,
            'game_day'=>$request->game_day,
            'status'=>0,
            'payment_status'=>0,
            'price_batch'=>$max_batch,
            'approved_by'=>null,
        ]);
        return redirect()->back()->with('status','info')->with('message','Booking waiting for approval.');
    }

    public function profileAttachWIthPhone(GetPlayerProfileRequest $request)
    {
        $profile=PlayerProfile::wherePhone($request->phone)->first();
        if($profile){
            $this->user->playerProfile()->save($profile);
        }else{
            $this->user->playerProfile()->create([
                'phone'=>$request->phone
            ]);
        }
        $response=route('player_front_profile');
        return response()->json(['route'=>"$response"]);
    }

    public function phoneVerifyGet()
    {
        return view($this->folder.'.phone_verifier',$this->kicksalData);
    }


    public function phoneVerifyInput(GetPlayerProfileRequest $request)
    {
        $user=PlayerProfile::wherePhone($request->phone)->has('User')->first();
        if(!$user){
            return response()->json(['status'=>true]);
        }
        return response()->json(['status'=>false,'phone'=>['Given phone is already taken.']],409);
    }

    public function chnageMyUserName(Request $request)
    {
        $this->profile->user_name=$request->user_name;
        $this->profile->save();
        return response()->json(['user_name'=>$this->profile->user_name]);
    }

  /*  public function phoneVerify(Request $request)
    {

        if($this->phoneValidator($request)==false){

        }
        $phone=$request->session()->get('phone');


        return redirect()->back()->with('status','info')->with('message','Phone verified');
    }*/
    
    
    public function favouriteMaker($futsal,Request $request)
    {
        $favourite=$request->user()->playerProfile->favouriteFutsals()->find($futsal->id);
        if(!$favourite){
            $request->user()->playerProfile->favouriteFutsals()->attach([$futsal->id]);
            $data{'add'}='fa-heart';
            $data{'remove'}='fa-heart-o';
            $data{'message'}='Added To Favourite List.';
            $data{'status'}='success';
        }else{
            $request->user()->playerProfile->favouriteFutsals()->detach([$futsal->id]);
            $data{'add'}='fa-heart-o';
            $data{'remove'}='fa-heart';
            $data{'message'}='Removed from Favourite list.';
            $data{'status'}='warning';
        }
        return response()->json($data,200);

    }

    public function kicksalUserProfile()
    {
        $this->kicksalData['bookings']=$this->profile->bookings;
        return view($this->folder.'.my_profile',$this->kicksalData);
    }

    public function search(SearchRequest $request)
    {
        $this->kicksalData['query']=$query=$request->q;
        $this->kicksalData['results'] = Futsal::has('grounds')->has('timePrices')->search($query,null,true)->paginate(10);
        return view($this->folder.'.search_result',$this->kicksalData);
    }


    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user= Auth::user();
            $this->profile= $this->user->playerProfile?$this->user->playerProfile:false;
            $this->kicksalData['title']= $this->profile?$this->profile->user_name:null;
            $this->kicksalData['profile']= $this->profile;
            return $next($request);
        });
    }




}
