<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user=Auth::user();
        if($user->kicksalOwnerProfile){
            $route='kicksal';
        }elseif($user->staffProfile) {
            $route='futsal';
        }elseif($user->hasRole(Role::where('name','like','player_%')->first()->name)){
            $route='users';
        }else{
            abort(401,'We Dont know, what kind of user you are.');
        }


        $route.='_home';
        return redirect()->route($route);
        //return view('home');
    }
}
