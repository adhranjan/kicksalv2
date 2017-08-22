<?php

namespace App\Http\Controllers;

use App\Futsal;
use App\Http\Requests\FutsalCreation;
use App\PaymentGateway;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FutsalController extends Controller
{
    protected $kicksalData;
    protected $user;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Futsal $futsal)
    {
        $this->kicksalData['title']='Futsals';
        $this->kicksalData['futsals']=$futsal->paginate(10);
        return view('staff.Futsal.index',$this->kicksalData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->kicksalData['title']=Auth::USer()->name;
        return view('staff.Futsal.create',$this->kicksalData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FutsalCreation $request)
    {
        $book_via_app=$request->has('book_via_app')?'1':'0';
        $futsal=Futsal::create([
            'name'=>$request->name,
            'book_via_app'=>$book_via_app,
            'created_by'=>Auth::User()->id
        ]);


        $ownerAccount=User::create([
            'name'=>$request->admin,
            'email'=>$request->email,
            'password'=>bcrypt('kicksalapp'),
            'api_token'=>str_random(60),
        ]);

        $futsalAdminRole=Role::where('name','like','futsal_%')->get();

        $ownerAccount->attachRoles($futsalAdminRole); // giving him authority to be admin of given futsal, he now can create owners and staffs account

        $ownerAccount->staffProfile()->create([
            'futsal_id'=>$futsal->id
        ]);

        if($request->has('payment_gateway')){
            $futsal->paymentGateways()->attach($request->payment_gateway);
        }


        // send email
        return redirect()->back()->with('status','info')->with('head','Futsal Created')->with('message','Login Details is sent in given email address.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Futsal $futsal)
    {

        $this->kicksalData['title']=Auth::USer()->name;
        $this->kicksalData['futsal']=$futsal;
        return view('staff.Futsal.edit',$this->kicksalData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FutsalCreation $request, Futsal $futsal)
    {
        $staff=$futsal->admin->user;
        $staff->fill([
            'name'=>$request->admin,
            'email'=>$request->email,
        ])->save();

        $book_via_app=$request->has('book_via_app')?'1':'0';

        $futsal->fill([
            'name'=>$request->name,
            'book_via_app'=>$book_via_app
        ])->save();


        $paymentGateway=array();
        if($request->has('payment_gateway')){
            $paymentGateway=$request->payment_gateway;
        }
        $futsal->paymentGateways()->sync($paymentGateway);

        return redirect()->route('futsal.edit',$futsal->slug)->with('status','info')->with('head','Futsal Updated')->with('message','Futsal Detail Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(404);
    }

    public function __construct()
    {
        $this->kicksalData['payment_gateways']=PaymentGateway::pluck('name','id');
    }
}
