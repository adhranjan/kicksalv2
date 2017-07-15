<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookTime extends Model
{

    protected $table = 'book_time';

    protected $fillable = ['time'];

    public $timestamps=false;

}
