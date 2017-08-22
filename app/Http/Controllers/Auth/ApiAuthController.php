<?php

namespace App\Http\Controllers\Auth;

use App\AppImageResource;
use App\Role;
use App\User;
use GuzzleHttp\Exception\ClientException;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use League\Flysystem\Exception;

class ApiAuthController extends Controller
{

    public function redirectToProvider()
    {
        return Socialite::driver('google')
            ->redirect();
    }

    public function handleProviderCallback()
    {
        try {
        $user=Socialite::driver('google')->stateless()->user();
        }catch (ClientException $e) {
            echo "client exception";
            die();
        }catch (InvalidStateException $e) {
            echo "invalid exception";
            die();
        }catch (ConnectException $e) {
            echo "invalid exception";
            die();
        }


        $previousUser=User::whereEmail($user->email)->first();
        if($previousUser){
            Auth::login($previousUser, true);
        }else{
            $this->furtherProceed($user);
        }
        return redirect()->route('home');

    }

    function furtherProceed($oAuthUser){
        $image=null;
        if($oAuthUser->avatar_original){
            $image= $this->saveImage($oAuthUser->avatar_original);
        }else{
            $image=AppImageResource::whereStoragePath('avatars/no_avatar.png')->first();
        }
        $user=User::create([
            'name'=>$oAuthUser->name,
            'email'=>$oAuthUser->email,
            'suggest_password_change'=>1,
            'password'=>bcrypt($oAuthUser->token),
            'avatar_id'=>$image->id,
            'api_token'=>str_random(60),
        ]);
        $roles=Role::where('name','like','player_%')->get();
        $user->attachRoles($roles);
        Auth::login($user, true);
    }

    function saveImage($image){
        $imageUrl=explode('/',$image);
        $fileName=end($imageUrl);
        $extension=explode('.',$fileName)[1];
        $name=md5($image).'.'.$extension;
        $content = file_get_contents($image);
        try{
            Storage::put('avatars/'.$name, $content);
        }catch (Exception $e){

        }finally{
            squareImage(Image::make('storage/app/avatars/'.$name));
        }

        $image=AppImageResource::Create([
            'storage_path'=>'avatars/'.$name,
            'image_id'=>md5($name.date('Y-m-d:h-s-a'))
        ]);

        return $image;
    }



    public function apiSocialLogin(Request $request)
    {
        $email=$request->email;
        $previousUser=User::whereEmail($email)->first();
        $status = 200; // only changes if the user is already registered but not as player, how should use other app ! ! ! ! !
        if($previousUser){
            if($previousUser->user_type=='player'){
                Auth::login($previousUser, true);
            }else{
                $this->content['message'] = "Use different app for ".$previousUser->user_type;
                $status=401;
            }
        }else{
            $user= new User();
            $user->name =  $request->name;
            $user->email =  $email;
            $user->avatar_original =  $request->avatar_original;
            $user->token =  $request->token;
            $this->furtherProceed($user);
        }

        if(Auth::User()){
            $user = User::with('playerProfile')->find(Auth::user()->id);
            /*    $user->api_token=str_random(60);
                $user->save();*/

            $this->content['user'] = $user;
            $this->content['token'] = $user->api_token;
        }
        return response()->json($this->content, $status);

    }

}
