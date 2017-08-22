<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingPayment extends Model
{
    use SoftDeletes;

    protected $table = 'payment_for_booking';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = ['booking_id','advance_booking','hand_cash_amount','discount','staff_id'];


    public function Booking()
    {
        return $this->belongsTo(Booking::class,'booking_id');
    }





}
