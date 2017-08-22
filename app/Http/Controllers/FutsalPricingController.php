<?php

namespace App\Http\Controllers;

use App\BookTime;
use App\FutsalTimePriceAtGivenDay;
use App\WeekDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FutsalPricingController extends Controller
{

    protected $folder='ground', $futsal,$kicksalData ,$user,$staffProfile , $bookings;


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

    public function index()
    {
        return redirect()->route('time-price.create');
    }
    
    public function create()
    {
        $this->kicksalData['title']=$this->user->name;
        $this->kicksalData['week_days']=WeekDay::all();
        $this->kicksalData['booking_times']=BookTime::all();
        $this->kicksalData['time_prices']=FutsalTimePriceAtGivenDay::where('futsal_id',$this->futsal->id);
        return view($this->folder.'.Price.create',$this->kicksalData);
    }

    public function store(Request $request)
    {

        $timePriceArray=$request->time_price;

        foreach ($timePriceArray as $index=>$times){
            $weekDay= WeekDay::find($index);
            if($weekDay){
                foreach ($times as $index=>$price){
                    $bookTime=BookTime::find($index);
                    if($bookTime){
                        if($price){
                            $time_price=$this->futsal->timePrices()->whereTimeId($bookTime->id)->whereDayId($weekDay->id);
                            $max_batch=$time_price->max('batch');
                            $exists=$time_price->whereBatch($max_batch)->first();

                            if($exists && $exists->price !=doubleval($price)){
                                    $batch=$exists->batch+1;
                                    $data=array('futsal_id'=>$this->futsal->id,
                                        'day_id'=>$weekDay->id,
                                        'time_id'=>$bookTime->id,
                                        'price'=>doubleval($price),
                                        'batch'=>$batch);
                            }elseif($exists && $exists->price ==doubleval($price)){
                                continue;
                            }
                            else{
                                $batch=1;
                                $data=array('futsal_id'=>$this->futsal->id,
                                    'day_id'=>$weekDay->id,
                                    'time_id'=>$bookTime->id,
                                    'price'=>doubleval($price),
                                    'batch'=>$batch);
                            }

                            $this->insert($this->futsal,$data);
                        }
                    }
                }
            }
        }
        return redirect()->back()->with('status','info')->with('head','Price Updated')->with('message','Price has been updated');
    }

    function insert($futsal,$timePrice){
        $futsal->timePrices()->create(
            $timePrice
        );
        return true;
    }

    public function show()
    {
        abort(404);
    }
    public function edit()
    {
        abort(404);
    }


}
