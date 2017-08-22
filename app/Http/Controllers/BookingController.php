<?php

namespace App\Http\Controllers;

use App\BookTime;
use App\Futsal;
use App\Http\Requests\CreateBookingRequest;
use App\Http\Requests\GetPlayerProfileRequest;
use App\PlayerProfile;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    protected $folder='ground', $kicksalData ,$futsal,$user,$staffProfile , $bookings;


    public function index()
    {
        $bookingInstance=$this->futsal->bookings()->with('bookedForTime','bookedByPlayer');
        $this->kicksalData['bookings']=$bookingInstance->paginate(20);
        return view($this->folder.'.Booking.index',$this->kicksalData);
    }

    public function create(){
        $this->kicksalData['book_time']=BookTime::pluck('start_time','id');
        $this->kicksalData['ground_id']=$this->futsal->grounds()->pluck('name','id');
        return view($this->folder.'.Booking.create',$this->kicksalData);
    }


    public function Store(CreateBookingRequest $request)
    {
        $player=PlayerProfile::wherePhone($request->phone)->find($request->player_id);
        $time_price=$this->futsal->timePrices()->whereTimeId($request->book_time)->whereDayId(dayToWeekDay($request->game_day)->id);
        $max_batch=$time_price->max('batch');
        $this->futsal->grounds()->find($request->ground_id)->bookings()->create([
            'book_time'=>$request->book_time,
            'player_id'=>$player->id,
            'game_day'=>$request->game_day,
            'status'=>1,
            'payment_status'=>1,
            'price_batch'=>$max_batch,
            'approved_by'=>$this->staffProfile->id,
        ]);
        return redirect()->back()->with('status','info')->with('head','Game Booked')->with('message','Booking has been created');
    }



    public function getPlayerDetail(GetPlayerProfileRequest $request)
    {
        $player=PlayerProfile::wherePhone($request->phone)->first();
        if(!$player){
            $player=PlayerProfile::create([
                 'phone'=>$request->phone,
            ]);
            $player=PlayerProfile::find($player->id);
        }

        $data['player_id']=$player->id;
        $data['name']=$player->user_name;
        $data['total']=$player->bookings()->count();
        $data['avatar']=$player->avatar;
        $data['accepted']=$player->bookings()->whereStatus('1')->count();
        $data['rejected']=$player->bookings()->whereStatus('2')->count();
        $data['cancelled']=$player->bookings()->whereStatus('3')->count();
        $data['games_in_my_futsal']=$player->bookings()->whereIn('ground_id',$this->futsal->grounds()->pluck('id')->toArray())->count();
        $data['credit_in_my_futsal']=0;
        $nonpaidBookings=$player->bookings()->where('payment_status','<>',2)->get();
        foreach ($nonpaidBookings as $nonPaidBooking){
            $data['credit_in_my_futsal']+=getTransactionDetailHtml($nonPaidBooking)['remaining'];
        }
        $data['other_detail']='This is some wired message';
        return json_encode($data,200);
    }


/*    public function apiBookAGame(CreateBookingRequest $request,Futsal $futsal)
    {
        $player=$request->user()->playerProfile;
        $futsal=$request->futsal;
        $time_price=$futsal->timePrices()->whereTimeId($request->book_time)->whereDayId(dayToWeekDay($request->game_day)->id);
        $max_batch=$time_price->max('batch');
        try{
            $status='success';
            $message='Booking has been created';
            $futsal->grounds()->find($request->ground_id)->bookings()->create([
                'book_time'=>$request->book_time,
                'player_id'=>$player->id,
                'game_day'=>$request->game_day,
                'status'=>0,
                'payment_status'=>0,
                'price_batch'=>$max_batch,
            ]);
        }catch (QueryException $exception){
            $status='fail';
            $message='Something Went Wrong';
        }catch (Exception $exception){
            $status='fail';
            $message='Something Went Wrong';
        }
        return response()->json(['status'=>$status,'message'=>$message]);   
    }*/



    public function __construct()
    {
        $this->kicksalData['title']="Booking";
        $this->middleware(function ($request, $next) {
            $this->user=Auth::User();
            $this->staffProfile= $this->user->staffProfile;
            $this->futsal= $this->staffProfile->relatedFutsal;
            return $next($request);
        });
    }





}
