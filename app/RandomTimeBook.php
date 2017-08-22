<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RandomTimeBook extends Model
{
    use SoftDeletes;

    protected $table='random_time_booking';
    protected $fillable=['booking_id','start_time','end_time'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'booking_id' => 'integer',
    ];


}
