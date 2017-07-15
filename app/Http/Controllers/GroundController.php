<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMyFutsalUser;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Auth;

class GroundController extends Controller
{
    protected $folder='ground';
    protected $kicksalData;

    public function index()
    {
        $this->kicksalData['title']=Auth::User()->name;
        return view($this->folder.'.home',$this->kicksalData);
    }

    public function createMyUser()
    {

        $this->kicksalData['title']=Auth::User()->name;
        return view($this->folder.'.user.create',$this->kicksalData);
    }

    public function createMyUserPost(CreateMyFutsalUser $request)
    {
        $role=Role::whereName('futsal_staffs');
        if($request->has('is_owner')){
            $role=$role->orWhere('name','futsal_owners');
        }
        $role=$role->pluck('id')->toArray();

        $Pass=substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 8);

        $groundUser=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($Pass),
        ]);
        $groundUser->workingFutsal()->attach([Auth::User()->myFutsal()->id]);
        $groundUser->roles()->attach($role);
        return redirect()->back()->with('status','info')->with('head','User Created')->with('message','Login Details is sent in given email address.'.$Pass);
    }

    public function userLists()
    {
        $this->kicksalData['title']=Auth::User()->name;
        $this->kicksalData['users']=Auth::User()->myFutsal()->staffs()->where('id','<>',Auth::User()->id)->paginate(10);
        return view($this->folder.'.user.index',$this->kicksalData);
    }

    public function userEdit($user_id)
    {
        $this->kicksalData['user']=$user=Auth::User()->myFutsal()->staffs()->where('id','<>',Auth::User()->id)->find($user_id);
        abort_if(!$user,404);
        $this->kicksalData['title']=$user->name;
        return view($this->folder.'.user.edit',$this->kicksalData);
    }

    public function userEditPost(CreateMyFutsalUser $request,$id)
    {
        $groundUser=Auth::User()->myFutsal()->staffs()->where('id','<>',Auth::User()->id)->find($id);
        abort_if(!$groundUser,404);
        $groundUser->fill([
            'name'=>$request->name,
            'email'=>$request->email,
        ])->save();


        $role=Role::whereName('futsal_staffs');
        if($request->has('is_owner')){
            $role=$role->orWhere('name','futsal_owners');
        }
        $role=$role->pluck('id')->toArray();
        $groundUser->roles()->sync($role);
        return redirect()->back()->with('status','info')->with('head','User Updated')->with('message','User has been updated.');
    }

}
