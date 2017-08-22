<?php

namespace App\Http\Controllers;

use App\BookingPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{

    protected $folder='bills', $futsal,$kicksalData ,$user,$staffProfile , $bookings;

    public function index(Request $request)
    {
        $myBook=$this->futsal->bookings();
        if($request->has('ds_') && $request->has('de_')){
            $myBook=$myBook->where('game_day','>=',$request->ds_)->where('game_day','<=',$request->de_);
            $period=$request->ds_.' to '.$request->de_;
        }else{
            $period="Today";
            $myBook=$myBook->where('game_day',date('Y-m-d'));
        }
        $this->kicksalData['period']=$period;
        $this->kicksalData['total_games']=$myBook->count();
        $this->kicksalData['bookings']=$myBook->orderBy('game_day','asc')->paginate(10);
        return view('ground.'.$this->folder.'.index',$this->kicksalData);
    }


    public function summary(Request $request)
    {
        $myBook=$this->futsal->bookings();
        if($request->has('ds_') && $request->has('de_')){
            $myBook=$myBook->where('game_day','>=',$request->ds_)->where('game_day','<=',$request->de_);
            $period=$request->ds_.' to '.$request->de_;

        }else{
            $period="Today";
            $myBook=$myBook->where('game_day',date('Y-m-d'));
        }
        $this->kicksalData['period']=$period;
        $this->kicksalData['total_games']=$myBook->count();
        $myBook=$myBook->get();

        $totalPrice=0;
        $totalDiscount=0;
        $totalReceivable=0;
        $totalReceived=0;
        $totalRemaining=0;


        foreach ($myBook as $booking){
            $totalPrice+=$booking->getBookingAmount();
            $totalDiscount+=$booking->getBookingDiscount();
            $totalReceivable+=$booking->getBookingAmount()-$booking->getBookingDiscount();
            $totalReceived+=$booking->getBookingCollectionNoDiscount();
            $totalRemaining+=($booking->getBookingAmount()-$booking->getBookingDiscount())-$booking->getBookingCollectionNoDiscount();
        }

        $this->kicksalData['total_price']=$totalPrice;
        $this->kicksalData['total_discount']=$totalDiscount;
        $this->kicksalData['total_receivable']=$totalReceivable;
        $this->kicksalData['total_received']=$totalReceived;
        $this->kicksalData['total_remaining']=$totalRemaining;
        return view('ground.'.$this->folder.'.summary',$this->kicksalData);





    }

    public function __construct()
    {
        $this->kicksalData['title']="Bills";
        $this->middleware(function ($request, $next) {
            $this->user=Auth::User();
            $this->staffProfile= $this->user->staffProfile;
            $this->futsal= $this->staffProfile->relatedFutsal;
            return $next($request);
        });

    }

}
