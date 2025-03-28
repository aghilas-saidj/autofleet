<?php

namespace App\Helpers;

use App\Services\CarsWithAvailabilityService;
use App\Services\CarsWithoutUnavailabilityService;
use App\Services\CarServices;

class GetCarsbyDates
{
    protected $carswithavailabilityservice;
    protected $carswithoutunavailabilityservice;
    protected $carService;

    public function __construct(
        CarsWithAvailabilityService $carswithavailabilityservice,
        CarsWithoutUnavailabilityService $carswithoutunavailabilityservice,
        CarServices $carService
    ) {
        $this->carswithavailabilityservice = $carswithavailabilityservice;
        $this->carswithoutunavailabilityservice = $carswithoutunavailabilityservice;
        $this->carService = $carService;
    }

    public function getCarsWithAvailability($from = null, $to = null)
    {


    
		$dateFormat = 'Y-m-d H:i';

		// Check if the 'from' date is in the correct format
		if ($from && !\DateTime::createFromFormat($dateFormat, $from)) {
			return response()->json(['message' => 'Invalid "from" date format. Expected format: YYYY-MM-DD HH:MM from dates seletion'], 422);

		}
	
		// Check if the 'to' date is in the correct format
		if ($to && !\DateTime::createFromFormat($dateFormat, $to)) {
			return response()->json(['message' => 'Invalid "to" date format. Expected format: YYYY-MM-DD HH:MM from dates seletion'], 422);
		}

        $availability = $this->carswithavailabilityservice->get($from, $to);
        $unavailability = $this->carswithoutunavailabilityservice->get($from, $to);




        $unavailableCarIds = collect($unavailability);

//      $availableCarIds = $availability->pluck('car_id')->toArray();

        $filteredAvailability = $availability->reject(function ($item) use ($unavailableCarIds) {
            return $unavailableCarIds->contains($item->car_id);
        });

        // The $filteredAvailability collection now excludes the matching IDs


        return response()->json($filteredAvailability);
    }



}
