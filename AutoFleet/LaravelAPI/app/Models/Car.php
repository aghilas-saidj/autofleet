<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;


    protected $fillable = [     
    'name',
    'type',
    'price_per_day',
    'seats',
    'description',
    'image_path',
    'bags',
    'doors',
    'airconditioning',
    'transmission',
    'engine_type',
    'refundable_security_deposit',
    'included_insurance',
    'fuel_policy',
    'is_unlimited_mileage',
    'mileage',
    'collision_damage_waiver',
    'Theft_Protection',
    'roadside_assistance',
    'third_party_liability',
    'cancellation_policy',
    'better_to_know',
    'under_maintenance',
    ];



public function images()
{
    return $this->hasMany(Image::class);
}





public function pickups()
{
    return $this->hasMany(Pickup::class);
}



public function dropoffs()
{
    return $this->hasMany(Dropoff::class);
}


}
