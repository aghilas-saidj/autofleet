<?php
namespace App\Services;


use App\Models\Availability;



class CarsWithAvailabilityService
{


    	
    protected $availability;

    public function __construct(Availability $availability)
    {
        $this->availability = $availability;
    }







    
    public function get($from = null, $to = null)
    {
        $query = $this->availability->query();

        if ($from) {
            $query->where('available_from', '<=', $from);
        }

        if ($to) {
            $query->where('available_to', '>=', $to)
                  ->where('available_from', '<=', $to);
        }

        return $query->with('car')->get();
    }










    public function isCarAvailable($carId, $from, $to)
    {
        // Validate inputs
        $query = $this->availability->query();

        // Filter by car_id
        $query->where('car_id', $carId);
    
        // Add the "from" condition
        if ($from) {
            $query->where('available_from', '<=', $from);
        }
    
        // Add the "to" condition
        if ($to) {
            $query->where('available_to', '>=', $to)
                  ->where('available_from', '<=', $to);
        }
        return $query->with('car')->get();

 
    }



}
