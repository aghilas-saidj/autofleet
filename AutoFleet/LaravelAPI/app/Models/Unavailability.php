<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unavailability extends Model
{

    use HasFactory;

    protected $table = 'unavailability';


    protected $fillable = [   
        'booking_id', 
	    'car_id', 
        'unavailable_from',
        'unavailable_to',
        'reason'
        ];

        
    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id'); // Assuming 'car_id' is the foreign key
    }
}
