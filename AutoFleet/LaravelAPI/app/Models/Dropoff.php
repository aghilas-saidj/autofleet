<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dropoff extends Model
{
    use HasFactory;



    protected $fillable = [
        'location_id',
        'car_id',
        'location_name',
    ];


    
    // Specify the table if it's not the plural form of the model name
    protected $table = 'dropoffs';

    // Define relationships if needed
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
