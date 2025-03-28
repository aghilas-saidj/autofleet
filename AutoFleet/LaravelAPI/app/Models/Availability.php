<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{

    use HasFactory;


    protected $table = 'availability';


    protected $fillable = [     
    	'car_id',
        'available_from',
        'available_to',
        ];

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id'); // Assuming 'car_id' is the foreign key
    }

}
