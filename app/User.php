<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
/*use Socialite;*/


class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar_id','api_token'
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','api_token'
    ];



    /* Mutators */

    public function setNameAttribute($value){
        $this->attributes['name']= ucfirst($value);
    }




    /* Mutators */




    /* Relations */



    public function staffProfile()
    {
        // if he is a staff, he will have this relation
        return $this->hasOne(StaffProfile::class,'user_id');
    }

    public function kicksalOwnerProfile()
    {
        // if he is a owner, he will have this relation
        return $this->hasOne(KicksalOwnerProfile::class,'user_id');
    }


    public function playerProfile()
    {
        // if he is a player, he will have this relation
        return $this->hasOne(PlayerProfile::class,'user_id');
    }



    /* Relations */



    public function getAvatarIdAttribute()
    {   //make it work according to this, dont change here !!! ! ! !!
        return AppImageResource::find($this->getOriginal('avatar_id'))->image_id;
    }

    public function getAvatarObjectAttribute()
    {//feels like it will work !!
        return AppImageResource::find($this->getOriginal('avatar_id'));
    }


    public function getUserTypeAttribute(){
        return explode('_',$this->roles()->first()->name)[0];
    }
    /****************/
}
