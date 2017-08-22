<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FutsalTimePriceAtGivenDay extends Model
{
    use SoftDeletes;

    protected $fillable = ['futsal_id','day_id','time_id','price','batch'];
    protected $table = 'futsal_price_day_time';


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'price' => 'double',
    ];


    public function weekDay()
    {
       return $this->belongsTo(WeekDay::class,'day_id');
    }

    public function time()
    {
       return $this->belongsTo(BookTime::class,'time_id');
    }


}
