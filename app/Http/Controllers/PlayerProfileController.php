<?php

namespace App\Http\Controllers;

use App\AppImageResource;
use App\Http\Requests\ChangeDisplayPictureRequest;

use Illuminate\Support\Facades\Auth;


class PlayerProfileController extends Controller
{

    public function changeDp(ChangeDisplayPictureRequest $request)
    {
            $image=$request->file('image');
            if($image != null && $image != '' && !empty($image) && isset($image)){
                $path=imageAvatarUpload($image,'avatars');
                $avatar=AppImageResource::create([
                    'storage_path'=>$path,
                    'image_id'=>md5($path.date('Y-m-d:h-s-a'))
                ]);
            }
        Auth::User()->fill([
            'avatar_id'=>$avatar->id
        ])->save();
        return response()->json(['avatar'=>Auth::User()->avatar_id]);
    }

}
