<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BookTime extends Model
{
    use SoftDeletes;
    protected $table = 'book_time';

    protected $fillable = ['start_time','end_time'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
