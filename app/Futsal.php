<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Nicolaslopezj\Searchable\SearchableTrait;




class Futsal extends Model
{
    use SoftDeletes;
    use Sluggable;
    use SearchableTrait;



    protected $table='futsals';
    protected $fillable=['name','address','telephone','map_coordinates','book_via_app','avatar_id','created_by'];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $searchable = [
        'columns' => [
            'futsals.name' => 20,
            'futsals.address' => 8,
            'futsals.map_coordinates' => 2,
        ]
    ];


    protected $casts = [
        'created_by' => 'integer',
    ];

    protected $hidden = array('pivot');



    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate'=>true
            ]
        ];
    }

    /* <mutators> */
    public function setNameAttribute($value){
        $this->attributes['name']= ucfirst($value);
    }

    public function setAddressAttribute($value){
        $this->attributes['address']= ucfirst($value);
    }

    public function getBookViaAppAttribute($value){
        return bookable()[$value];
    }

    public function getAvatarIdAttribute()
    {//make it work according to this, dont change here !!! ! ! !!
        return AppImageResource::find($this->getOriginal('avatar_id'))->image_id;
    }

    public function getAvatarObjectAttribute()
    {
        return AppImageResource::find($this->avatar_id);
    }


    /*    public function avatar()
       {
           return $this->belongsTo(AppImageResource::class,'avatar_id');
       }
   */

    /* </mutators> */



    /* <relations> */

    public function creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function staffs()
    {
        return $this->hasMany(StaffProfile::class,'futsal_id');
    }

    public function admin()
    {
        return $this->hasOne(StaffProfile::class,'futsal_id')->whereHas('User',function($user){
            $user->whereHas('roles',function($roles){
                $roles->where('name', 'futsal_admin');
            });
        });
    }

    public function paymentGateways()
    {
        return $this->belongsToMany(PaymentGateway::class,'futsal_payments','futsal_id','payment_id');
    }


    public function timePrices()
    {
        return $this->hasMany(FutsalTimePriceAtGivenDay::class,'futsal_id');
    }

    public function grounds()
    {
        return $this->hasMany(FutsalGrounds::class,'futsal_id');
    }

    /* </relations> */



    public function bookings()
    {
        // returns booking instance of all of it's grounds
        $booking=Booking::whereHas('bookedForGround',function($bookedForGround){
            $bookedForGround->whereHas('futsal',function ($futsal){
                $futsal->where('id',$this->id);
            });
        });
        return $booking;
    }

}
