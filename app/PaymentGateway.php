<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{

    protected $table = 'payment_gateway';

    protected $fillable = ['name','api_url'];

    public $timestamps=false;

}
