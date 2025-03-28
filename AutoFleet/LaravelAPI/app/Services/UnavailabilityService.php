<?php

namespace App\Services;

/**
 * 
 */

use App\Models\Unavailability;

use Illuminate\Database\Eloquent\ModelNotFoundException;


class UnavailabilityService
{

    protected $unavailability;

    public function __construct(Unavailability $unavailability)
    {
        $this->unavailability = $unavailability;
    }










    


    public function createUnavailability($data)
    {
        // Validate the data before creating, if needed
        $unavailability = Unavailability::create($data);

        return $unavailability;
    }















    public function deleteUnavailability($id)
    {
        $unavailability = Unavailability::find($id);

        if (!$unavailability) {
            throw new ModelNotFoundException('Unavailability not found');
        }

        return $unavailability->delete();
    }














    public function getAllUnavailability()
    {
        return Unavailability::all();
    }















    public function getUnavailabilityById($id)
    {
        $unavailability = Unavailability::find($id);

        if (!$unavailability) {
            throw new ModelNotFoundException('Unavailability not found');
        }

        return $unavailability;
    }

















    public function getUnavailabilityByCarId($car_id)
    {
    	$carUnavailability = Unavailability::where('car_id', $car_id)->get(); // Use where() instead of find()


	    if (!$carUnavailability) {
            throw new ModelNotFoundException('Unavailability not found');
        }

        return $carUnavailability;

    }



















    public function deleteUnavailabilityByBookingID($booking_id)
    {
        $unavailability = Unavailability::where('booking_id', $booking_id)->first();

        
        if (!$unavailability) {
            throw new ModelNotFoundException('Unavailability not found');
        }
        $unavailability->delete();
    
        return response()->json(['message' => 'Unavailability record deleted successfully']);
    }
    


}