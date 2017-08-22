<?php
namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBookingRequest;
use Illuminate\Http\Request;

class ApiBookingController extends Controller
{

    protected $user;
    protected $profile;
    protected $futsal;

    public function index(Request $request)
    {
        //perfect
        $this->futsal=$request->futsal;
        $bookings=$request->futsal->bookings()->with('bookedForGround')->paginate(20);
        return response()->json($bookings,200);
    }


    public function Store(CreateBookingRequest $request)
    {
        $futsal=$request->futsal;

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
        return response()->json(['status'=>'success','message'=>'Booking has been posted'],200);
    }


    public function userBookings()
    {
        $bookings=$this->profile->bookings()->with('bookedForGround.futsal')->paginate(20);
        return response()->json($bookings,200);
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
