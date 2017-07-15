<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table='game_bookings';
    protected $fillable=['player_id','futsal_id','book_time','game_day','status','booking_code'];

    public $timestamps=false;

    protected $casts = [
        'player_id' => 'integer',
        'futsal_id' => 'integer',
        'book_time' => 'integer',
    ];


    /* <mutators>*/
    public function getBookTimeAttribute()
    {
        return $this->bookingTime?$this->bookingTime->time:$this->randomTimeBooking->start_time.'-'.$this->randomTimeBooking->end_time;
    }

    /* </mutators>*/





    /* <relations>*/

    public function bookedByPlayer()
    {
        return $this->belongsTo(PlayerProfile::class,'player_id');
    }

    public function bookedAtFutsal()
    {
        return $this->belongsTo(Futsal::class,'futsal_id');
    }


    public function bookingTime()
    {
        return $this->belongsTo(BookTime::class,'book_time');
    }


    public function randomTimeBooking()
    {
        return $this->hasOne(RandomTimeBook::class, 'booking_id');
    }


    public function bookingPayment()
    {

    }


    /* </relations>*/
}
