<?php

namespace App\Http\Controllers;

use App\AppImageResource;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class ImageController extends Controller
{

    protected $width;
    protected $circle=false;



    public function getAvatarImage(Request $request,$name)
    {
        $this->initializeRequest($request);
        $image=AppImageResource::whereImageId($name)->first();
        abort_if(!$image,200);
        $changeImage=$image->storage_path;
        try {
            $img = Storage::get($image->storage_path);
        } catch (FileNotFoundException $e) {
            $path=explode('/',$image->storage_path)[0];
            $changeImage=$path.'/no_avatar.png';
            $img = Storage::get($changeImage);
        }

        if($this->width){
            $img=$this->resize($changeImage);
        }
        return response($img, 200)->header('Content-Type', 'image/jpeg');
    }


    function resize($image){
        $image=Image::make('storage/app/'.$image);
            $image->resize($this->width, null, function ($constraint) {
                $constraint->aspectRatio();
            });


        $image=Image::make($image->save($image->dirname.'/'.$this->width));
        return $image;
    }


    function initializeRequest($request){
        if($request->has('width')){
            if($request->width>=1000){
                $this->width=1000;
            }else{
                $this->width=$request->width;
            }
        }
    }


}
