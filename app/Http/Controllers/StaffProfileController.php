<?php

namespace App\Http\Controllers;

use App\AppImageResource;
use App\Http\Requests\UpdateStaffProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StaffProfileController extends Controller
{
    protected $folder='ground.Staffprofile';
    protected $kicksalData;

    public function index()
    {
        abort(404);
    }



    public function create(){
        abort(404);
    }



    public function show($staff)
    {
        if(Auth::User()->hasRole('futsal_admin') || Auth::User()->hasRole('futsal_owners')){
            $staff=Auth::User()->staffProfile->relatedFutsal->staffs()->find($staff);
        }else{
            $staff=Auth::User()->staffProfile()->find($staff);
        }

        abort_if(!$staff,404);
        $this->kicksalData['profile']=$staff;
        $salesAmount=array();
        $collectedAmount=array();
        $discountedAmount=array();
        $collectionRemaining=array();
        $months=array();
        for($i =1;$i<=12;$i++){
            $salesAmount[$i]=0;
            $collectedAmount[$i]=0;
            $discountedAmount[$i]=0;
            $collectionRemaining[$i]=0;
            $sales=$staff->bookingTransaction()->where(DB::raw('Month(game_day)'),sprintf("%02d", "$i"))->where(DB::raw('Year(game_day)'),date('Y'))->get();
            foreach ($sales as $sale){
                $salesAmount[$i]+=$sale->getBookingAmount();
                $collectionRemaining[$i]+=($sale->getBookingAmount()-$sale->getBookingDiscount())-$sale->getBookingCollectionNoDiscount();
            }
            $collection=$staff->cashCollection()->where(DB::raw('Month(created_at)'),sprintf("%02d", "$i"))->where(DB::raw('Year(created_at)'),date('Y'))->get();
            foreach ($collection as $collect){
                $collectedAmount[$i]+=$collect->hand_cash_amount;
                $discountedAmount[$i]+=$collect->discount;

            }
            $months[]=date("F", strtotime("$i/12/10"));
        }

        $this->kicksalData['months']=$months;
        $this->kicksalData['collected_amount']=$collectedAmount;
        $this->kicksalData['sales_amount']=$salesAmount;
        $this->kicksalData['discount_amount']=$discountedAmount;
        $this->kicksalData['collection_remaining_amount']=$collectionRemaining;
        return view($this->folder.'.show',$this->kicksalData);




    }
    public function edit($staff)
    {
        $staff=Auth::User()->staffProfile()->find($staff);
        abort_if(!$staff,404);
        $this->kicksalData['profile']=$staff;


        return view($this->folder.'.edit',$this->kicksalData);
    }

    public function update($staff,UpdateStaffProfileRequest $request)
    {
        $staff=Auth::User()->staffProfile()->find($staff);

        abort_if(!$staff,404);
        $avatar=$staff->User->avatar_object;
        if($request->file('image')){
            $image=$request->file('image');
            if($image != null && $image != '' && !empty($image) && isset($image)){
                $path=imageAvatarUpload($image,'avatar');
                    $avatar=AppImageResource::create([
                        'storage_path'=>$path,
                        'image_id'=>md5($path.date('Y-m-d:h-s-a'))
                      ]);
                }
        }
        $staff->fill([
            'phone'=>$request->phone,
            'user_name'=>$request->user_name,
            'gender'=>$request->gender,
        ])->save();

        $staff->User->fill([
            'avatar_id'=>$avatar->id,
        ])->save();

        return redirect()->back()->with('status','info')->with('head','Profile Updated')->with('message','Profile has been updated');
    }


    public function __construct()
    {
        $this->kicksalData['title']="Profile";
    }
}
