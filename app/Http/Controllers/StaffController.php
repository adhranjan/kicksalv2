<?php

namespace App\Http\Controllers;


use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class StaffController extends Controller
{
    protected $folder='staff';
    protected $kicksalData;

    public function index()
    {
        $this->kicksalData['title']=Auth::User()->name;
        return view('ground.home',$this->kicksalData);
    }
}
