<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['car_id', 'image_path'];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
