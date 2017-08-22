<?php
namespace App\Http\Controllers;

use App\Http\Requests\GetPlayerProfileRequest;
use App\PlayerProfile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
/*use Response;*/

class ApiController extends Controller
{
    public function __construct(){
        $this->content = array();
    }
    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')]) /*&& Auth::user()->user_type=='player'*/){
            $user = User::with('playerProfile')->find(Auth::user()->id);
        /*    $user->api_token=str_random(60);
            $user->save();*/
            $this->content['user'] = $user;
            $this->content['token'] = $user->api_token;
            $status = 200;
        }
        else{
            $this->content['error'] = "Unauthorised";
            $status = 401;
        }
        return response()->json($this->content, $status);
    }

    public function profileAttachWIthPhone(GetPlayerProfileRequest $request)
    {
        $profile=PlayerProfile::wherePhone($request->phone)->first();
        if($profile){
            $request->user()->playerProfile()->save($profile);
        }else{
            $request->user()->playerProfile()->create([
                'phone'=>$request->phone
            ]);
        }
        $this->content['status'] = "Success";
        $status = 200;
        return response()->json($this->content, $status);
    }
}