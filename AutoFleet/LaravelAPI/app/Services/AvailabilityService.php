<?php

namespace App\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;


/**
 * 
 */
use App\Models\Availability;

class AvailabilityService
{
	
    protected $availability;
    public function __construct(Availability $availability)
    {
        $this->availability = $availability;
    }




















    public function createAvailability($data)
    {
        // Validate the data, if needed, before creating
        $availability = Availability::create($data);

        return $availability;
    }














    public function updateAvailability($id, array $data)
    {
        $availability = Availability::find($id);

        if (!$availability) {
            throw new ModelNotFoundException('Availability not found');
        }
        $availability->update($data);

        return $availability;
    }













    public function deleteAvailability($id)
    {
        $availability = Availability::find($id);

        if (!$availability) {
            throw new ModelNotFoundException('Availability not found');
        }

        return $availability->delete();
    }









    public function getAllAvailability()
    {
        return Availability::all();
    }








    public function getAvailabilityById($id)
    {
        $availability = Availability::find($id);

        if (!$availability) {
            throw new ModelNotFoundException('Availability not found');
        }

        return $availability;
    }








    public function getAvailabilityByCarId($car_id)
    {
	    $carAvailability = Availability::where('car_id', $car_id)->get(); // Use get() to retrieve the results

        if (!$carAvailability) {
            throw new ModelNotFoundException('Availability not found');
        }

        return $carAvailability;

    }


}