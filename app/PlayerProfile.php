<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayerProfile extends Model
{
    protected $table='player_profile';

    protected $fillable=['user_id','phone','address'];

    protected $casts = [
        'user_id' => 'integer',
    ];



    /* <relations>*/

    public function User()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class,'player_id');
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
