<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

        // Define which fields are mass assignable
    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
    ];


    

    // Specify the table if it's not the plural form of the model name
    protected $table = 'locations';

    // If you have timestamps in your table, Laravel handles them automatically
    public $timestamps = true;

    // Define relationships if needed
    public function pickups()
    {
        return $this->hasMany(Pickup::class);
    }

    public function dropoffs()
    {
        return $this->hasMany(Dropoff::class);
    }
}
