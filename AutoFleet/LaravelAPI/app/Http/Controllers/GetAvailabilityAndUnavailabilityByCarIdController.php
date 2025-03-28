<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AvailabilityService;
use App\Services\UnavailabilityService;


class GetAvailabilityAndUnavailabilityByCarIdController extends Controller
{
    protected $availabilityService;
    protected $unavailabilityService;


    
    public function __construct(AvailabilityService $availabilityService, UnavailabilityService $unavailabilityService)
    {
        $this->availabilityService = $availabilityService;
        $this->unavailabilityService = $unavailabilityService;
    }









    public function getcaravailabilityandunavailability($car_id)
    {
    
    $carAvailability = $this->availabilityService->getAvailabilityByCarId($car_id);
	$carUnavailability = $this->unavailabilityService->getUnavailabilityByCarId($car_id);

    return response()->json([
        'car_availability' => $carAvailability,
        'car_unavailability' => $carUnavailability,
    ]);


}
}