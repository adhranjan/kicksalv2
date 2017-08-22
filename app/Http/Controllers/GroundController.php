<?php

namespace App\Http\Controllers;

use App\AppImageResource;
use App\Http\Requests\ChangeDisplayPictureRequest;
use App\Http\Requests\CreateMyFutsalUser;
use App\PlayerProfile;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroundController extends Controller
{
    protected $folder='ground', $kicksalData, $futsal,$user,$staffProfile;



    public function index()
    {
        $this->kicksalData['title']=$this->user->name;
        return view($this->folder.'.home',$this->kicksalData);
    }

    public function createMyUser()
    {
        $this->kicksalData['title']=$this->user->name;
        return view($this->folder.'.Staff.create',$this->kicksalData);
    }

    public function createMyUserPost(CreateMyFutsalUser $request)
    {
        $role=Role::whereName('futsal_staffs');
        if($request->has('is_owner')){
            $role=$role->orWhere('name','futsal_owners');
        }
        $role=$role->pluck('id')->toArray();


        $groundUser=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt('kicksalapp'),
            'api_token'=>str_random(60),
        ]);
        $groundUser->roles()->attach($role);

        $groundUser->staffProfile()->create([
            'futsal_id'=>$this->futsal->id
        ]);

        return redirect()->back()->with('status','info')->with('head','User Created')->with('message','Login Details is sent in given email address');
    }

    public function userLists()
    {
        $this->kicksalData['title']=$this->futsal->name;
        $this->kicksalData['staffs']=$this->futsal->staffs()->where('id','<>',$this->staffProfile->id)->paginate(10);
        return view($this->folder.'.Staff.index',$this->kicksalData);
    }

    public function userEdit($user_id)
    {
        $staffProfile=$this->futsal->staffs()->whereHas('User',function($user) use ($user_id){
            $user->where('id',$user_id);
            $user->where('id','<>',$this->user->id);
        })->first();
        // only let futsal admin edit staff's user that are from his futsal

        abort_if(!$staffProfile,404);

        $this->kicksalData['user']=$staffProfile->User;
        $this->kicksalData['title']=$staffProfile->User->name;
        return view($this->folder.'.Staff.edit',$this->kicksalData);
    }

    public function userEditPost(CreateMyFutsalUser $request,$user_id)
    {
        $staffProfile=$this->futsal->staffs()->whereHas('User',function($user) use ($user_id){
            $user->where('id',$user_id);
            $user->where('id','<>',$this->user->id);
        })->first();
        // only let futsal admin edit staff's user that are from his futsal

        abort_if(!$staffProfile,404);
        $staffProfile->User->fill([
            'name'=>$request->name,
            'email'=>$request->email,
        ])->save();


        $role=Role::whereName('futsal_staffs');
        if($request->has('is_owner')){
            $role=$role->orWhere('name','futsal_owners');
        }
        $role=$role->pluck('id')->toArray();
        $staffProfile->User->roles()->sync($role);
        return redirect()->back()->with('status','info')->with('head','User Updated')->with('message','User has been updated.');
    }


    public function getPlayerProfile($id)
    {
        $player=PlayerProfile::whereHas('bookings',function ($bookings){
            $bookings->whereIn('ground_id',$this->futsal->grounds()->pluck('id')->toArray());
        })->find($id);

        abort_if(!$player,401);
        $this->kicksalData['title']=$player->user_name;
        $this->kicksalData['player']=$player;
        $this->kicksalData['unpaidBookings']=$player->bookings()->where('payment_status','<>',2)->whereIn('ground_id',$this->futsal->grounds()->pluck('id')->toArray())->get();
        return view($this->folder.'.Player.profile',$this->kicksalData);
    }

    public function futsalBillPayment(Request $request,$id)
    {
        $player=PlayerProfile::whereHas('bookings',function ($bookings){
            $bookings->whereIn('ground_id',$this->futsal->grounds()->pluck('id')->toArray());
        })->find($id);
        abort_if(!$player,401);

        $bills=$request->bill_amt;

        foreach ($bills as $index=>$bill){
           $discount=$request->discount_amt[$index];
           $discount=$discount?$discount:0;
           $bill=$bill?$bill:0;
           $booking= $player->bookings()->find($index);
            $bookingClone=clone $booking;
            if($booking->getBookingAmount() >= $booking->getBookingCollection()+$discount+$bill){
                if($bill!=0 ||  $discount!=0){
                    $booking->bookingPayments()->create([
                        'hand_cash_amount'=>floatval($bill),
                        'staff_id'=>Auth::User()->staffProfile->id,
                        'advance_booking'=>0,
                        'discount'=>$discount,
                    ]);
                    $paymentStatus=0;
                    if($bookingClone->getBookingCollection()==$bookingClone->getBookingAmount()){ /// if collection is euqal to actual pay
                        $paymentStatus=2;
                    }else{// case
                        if($bill!=0){
                            $paymentStatus=1;
                        }
                    }
                    $booking->fill([
                        'payment_status'=>$paymentStatus
                    ])->save();
                }
            }

        }
        return redirect()->back()->with('status','info')->with('head','Payment Updated')->with('message','Payment has been updated.');

    }

    public function groundSetup()
    {
        $this->kicksalData['title']="Ground Setup";
        $this->kicksalData['grounds']=$this->futsal->grounds;
        return view($this->folder.'.Groundsetup.edit',$this->kicksalData);
    }

    public function groundSetupPost(Request $request)
    {

        $groundsNotToBeRemoved=array();

        foreach ($request->ground_names as $ground_name){
            if($ground_name){
                $ground=$this->futsal->grounds()->firstOrCreate([
                   'name'=>$ground_name
                ]);

                if (!in_array($ground->id, $groundsNotToBeRemoved)) {
                    array_push($groundsNotToBeRemoved,$ground->id);
                }
            }
        }

        $this->futsal->grounds()->whereNotIn('id',$groundsNotToBeRemoved)->whereDoesntHave('bookings')->delete();
        return redirect()->back()->with('status','info')->with('head','Grounds Updated')->with('message','Ground Setup Completed.');
    }


    public function displayPictureChangePost(ChangeDisplayPictureRequest $request)
    {
        $path=imageAvatarUpload($request->image,'futsals');

        $avatar=AppImageResource::create([
            'storage_path'=>$path,
            'image_id'=>md5($path.date('Y-m-d:h-s-a'))
        ]);

        $this->futsal->fill([
            'avatar_id'=>$avatar->id,
        ])->save();
        return redirect()->back()->with('status','info')->with('head','Image Updated')->with('message','Display Picture Updated.');
    }
    public function coordinatesPostChange(Request $request)
    {

        $coordinates=trim($request->coordinates,'()');
        $this->futsal->fill([
            'map_coordinates'=>$coordinates
        ])->save();
        return redirect()->back()->with('status','info')->with('head','Location Updated')->with('message','Your Location has been updated.');
    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user=Auth::User();
            $this->staffProfile= $this->user->staffProfile;
            $this->futsal= $this->staffProfile->relatedFutsal;
            return $next($request);
        });
    }


}
