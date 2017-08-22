<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class KicksalOwnerProfile extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id','user_name','phone','gender'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    protected $table = 'kicksal_owner_profile';


    public function User()
    {
        return $this->belongsTo(User::class,'user_id');
    }





}
