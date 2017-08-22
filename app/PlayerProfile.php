<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayerProfile extends Model
{
    use SoftDeletes;
    protected $table='player_profile';

    protected $fillable=['user_id','user_name','phone','address','gender'];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'user_id' => 'integer',
    ];



    public function getAvatarAttribute()
    { // perefect dont change here
        if(!$this->User){
            $image_id=AppImageResource::whereStoragePath('avatars/no_avatar.png')->first()->image_id;
        }else{
            $image_id=AppImageResource::find($this->User->getOriginal('avatar_id'))->image_id;
        }
        return $image_id;
    }

    public function setUserNameAttribute($value)
    {
        $this->attributes['user_name']= ucwords(strtolower($value));

    }

/*    public function getAvatarObjectAttribute()
    {
        if(!$this->User){
            $avatarObejct=AppImageResource::whereStoragePath('avatars/no_avatar.png')->first()->image_id;
        }else{
            $avatarObejct=AppImageResource::find($this->User->avatar_id)->image_id;
        }
        return $avatarObejct;
    }*/


    public function getUserNameAttribute($value)
    {
        return $value?$value:"Kicksal User";
    }

    public function getAddressAttribute($value)
    {
        return $value?$value:"N/A";
    }

    public function getGenderAttribute($value)
    {
        return $value?gender()[$value]:"N/A";
    }
    /* <relations>*/

    public function User()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class,'player_id');
    }

    public function favouriteFutsals()
    {
        return $this->belongsToMany(Futsal::class,'player_favourite_futsal','player_id','futsal_id');
    }
    

    public function cancelledBookings()
    {

    }

    public function pendingBookings()
    {

    }

    public function acceptedBookings()
    {

    }

    public function rejectedBookings()
    {

    }

    /* </relations>*/



}
