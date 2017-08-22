<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffProfile extends Model
{
    use SoftDeletes;

    protected $table = 'staff_profile';

    protected $fillable = ['user_id','user_name','phone','gender','futsal_id'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function getUserNameAttribute($value)
    {
        return $value?$value:"Staff";
    }


    public function User()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function relatedFutsal()
    {
        return $this->belongsTo(Futsal::class,'futsal_id');
    }


    public function bookingTransaction()
    {
       return $this->hasMany(Booking::class,'approved_by');
    }

    public function cashCollection()
    {
        return $this->hasMany(BookingPayment::class,'staff_id');
    }







}
