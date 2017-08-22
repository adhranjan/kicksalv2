<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppImageResource extends Model
{
    protected $table = 'images';

    protected $fillable = ['storage_path','image_id'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $hidden = [
        'storage_path'
    ];


    public function getImageIdAttribute($value)
    {
        return route('web_image',$value);
    }
}
