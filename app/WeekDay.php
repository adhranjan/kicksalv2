<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeekDay extends Model
{
    use SoftDeletes;

    protected $table = 'week_day';

    protected $fillable = ['day'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
