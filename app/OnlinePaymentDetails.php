<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class OnlinePaymentDetails extends Model
{
    use SoftDeletes;
    protected $table = 'online_payment_detail';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = ['payment_id','response','response_detail'];



}
