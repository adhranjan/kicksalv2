<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    /* Mutators */

    public function setNameAttribute($value){
        $this->attributes['name']= ucfirst($value);
    }

    /* Mutators */




    /* Relations */

    public function workingFutsal()
    {
        return $this->belongsToMany(Futsal::class,'futsal_staffs','user_id','futsal_id');
    }

    public function myFutsal() {
        return $this->workingFutsal()->first();
    }


    public function playerProfile()
    {
        return $this->hasOne(PlayerProfile::class,'user_id');
    }



    /* Relations */
}
