<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;



class Futsal extends Model
{
    use SoftDeletes;
    use Sluggable;



    protected $table='futsals';
    protected $fillable=['name','address','telephone','map_coordinates','book_via_app','created_by'];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'created_by' => 'integer',
    ];




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
    /* </mutators> */



    /* <relations> */

    public function creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function staffs()
    {
        return $this->belongsToMany(User::class,'futsal_staffs','futsal_id','user_id');
    }

    public function admin()
    {
       /* return $this->belongsToMany(User::class,'futsal_staffs','futsal_id','user_id')->whereHas('roles',function($q){
            $q->where('name', 'futsal_admin');
        })->first();


        return $this->staffs()->whereHas('roles', function($q){
            $q->where('name', 'futsal_admin');
        })->first();*/
    }

    public function paymentGateways()
    {
        return $this->belongsToMany(PaymentGateway::class,'futsal_payments','futsal_id','payment_id');
    }

    /* </relations> */

}
