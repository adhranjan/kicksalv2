<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Booking extends Model
{
    use SoftDeletes;

    protected $table='game_bookings';
    protected $fillable=['player_id','ground_id','book_time','game_day','status','booking_code','approved_by','price_batch','payment_status'];



    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'player_id' => 'integer',
        'ground_id' => 'integer',
        'book_time' => 'integer',
        'approved_by' => 'integer',
    ];


    /* <mutators>*/
    public function getBookTimeAttribute($value){
        return $value?BookTime::find($value)->start_time.':'.BookTime::find($value)->end_time:$this->randomTimeBooking->start_time.':'.$this->randomTimeBooking;
    }

    public function getStatusAttribute($value)
    {
        return bookingStatus()[$value];
    }

    public function getPaymentStatusAttribute($value)
    {
        return bookingPaymentStatus()[$value];
    }

    public function getCommitByAttribute()
    {
        return $this->approvedBy?$this->approvedBy->user_name:'Not Approved';
    }



    /* </mutators>*/





    /* <relations>*/

    public function bookedByPlayer()
    {
        return $this->belongsTo(PlayerProfile::class,'player_id');
    }



     public function bookedForGround(){
        return $this->belongsTo(FutsalGrounds::class,'ground_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(StaffProfile::class,'approved_by');
    }


    public function bookedForTime()
    {
        return $this->belongsTo(BookTime::class,'book_time');
    }


    public function randomTimeBooking()
    {
        return $this->hasOne(RandomTimeBook::class, 'booking_id');
    }


    public function randomOrNonRandomTime()
    { // that be random or booked for time
    }


    public function bookingPayments()
    {
        return $this->hasMany(BookingPayment::class,'booking_id');
    }



    /* </relations>*/


    /* <helpers>*/

    public function getBookingAmount()
    {
        $day=dayToWeekDay($this->game_day);
        $time=($this->getOriginal('book_time'));
        return floatval($this->bookedForGround->futsal->timePrices()->where('day_id',$day->id)->where('time_id',$time)->where('batch',$this->price_batch)->first()->price);
    }

    public function getBookingCollection()
    {
        $paid=0;
        foreach ($this->bookingPayments as $payment){

            $paid+=$payment->advance_booking;
            $paid+=$payment->hand_cash_amount;
            $paid+=$payment->discount;

        }
        return floatval($paid);
    }

    public function getBookingCollectionNoDiscount()
    {
        $paid=0;
        foreach ($this->bookingPayments as $payment){
            $paid+=$payment->advance_booking;
            $paid+=$payment->hand_cash_amount;
        }
        return floatval($paid);
    }

    public function getBookingDiscount()
    {
        $discount=0;
        foreach ($this->bookingPayments as $payment){
            $discount+=$payment->discount;

        }
        return floatval($discount);
    }









    /* </helpers>*/



}
