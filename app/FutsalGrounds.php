<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FutsalGrounds extends Model
{
    protected $table='grounds';
    protected $fillable=['name','futsal_id'];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'futsal_id' => 'integer',
    ];

    public function futsal()
    {
        return $this->belongsTo(Futsal::class,'futsal_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class,'ground_id');
    }



}
