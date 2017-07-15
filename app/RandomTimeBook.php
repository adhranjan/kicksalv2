<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RandomTimeBook extends Model
{
    protected $table='random_time_booking';
    protected $fillable=['booking_id','start_time','end_time'];

    public $timestamps=false;

    protected $casts = [
        'booking_id' => 'integer',
    ];


}
