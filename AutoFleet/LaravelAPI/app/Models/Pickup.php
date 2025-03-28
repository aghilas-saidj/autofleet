<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pickup extends Model
{
    use HasFactory;

    // Specify the table if it's not the plural form of the model name

	protected $fillable = [
	'location_id',  // The ID of the location where the car will be picked up
	'car_id',       // The ID of the car being picked up
    'location_name',
	];

    
    protected $table = 'pickups';

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
