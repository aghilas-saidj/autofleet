<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Services\CarServices;
use App\Http\Controllers\Controller;
use App\Helpers\CarsLocations;
use App\Helpers\GetCarsbyDates;

use App\Helpers\CalculatePrice;

use App\Services\CarsWithAvailabilityService;
use App\Services\CarsWithoutUnavailabilityService;


class infoConfirmationBeforeBookingService extends Controller
{
    protected $carslocations;
    protected $carService;
    protected $calculateprice;
    protected $carswithavailabilityservice;
    protected $carswithoutunavailabilityservice;
    protected $getcarsbydates;


    public function __construct(GetCarsbyDates $getcarsbydates , CarsLocations $carslocations, CarServices $carService , CalculatePrice $calculateprice , CarsWithAvailabilityService $carswithavailabilityservice, CarsWithoutUnavailabilityService $carswithoutunavailabilityservice)  
    {
        $this->getcarsbydates = $getcarsbydates;

        $this->carslocations = $carslocations;
        $this->carService = $carService;
		$this->calculateprice = $calculateprice;
        $this->carswithavailabilityservice = $carswithavailabilityservice;
        $this->carswithoutunavailabilityservice = $carswithoutunavailabilityservice;
        

    }  


    public function Confirm($car_id, $from, $to, $pickup, $dropoff, $totalPrice)
    {   
        $car = $this->carService->getCarById($car_id);

        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404); // Decode as associative array infoConfirmationBeforeBookingService verification
        }

        $calculatedPriceResponse = $this->calculateprice->BookingPrice($from, $to, $car_id);  


        $calculatedPriceString = $calculatedPriceResponse->getData()->total_price ?? null; // Use getData() to extract JSON data



        $calculatedPrice = (float) str_replace(',', '', $calculatedPriceString);


		




        $totalPriceCorrect = False;
        if ($calculatedPrice == $totalPrice) {
            $totalPriceCorrect = True ;
      
        }

      

        
        $dateResponse = [];
        $locationResponse = [];

        $location_response = $this->carslocations->getcars($pickup, $dropoff);
        $date_response = $this->getcarsbydates->getCarsWithAvailability($from, $to);




        return $date_response;
   

        if ($location_response == False) {
            return response()->json(False);
        }

        foreach ($date_response->original as $value) {
            $dateResponse[] = $value['car_id'];
        }




        foreach ($location_response['ids'] as $value) {
            $locationResponse[] = $value;
        }



     //   return $dateResponse;


        $valid = false;

        if (in_array($car->id, $dateResponse) && in_array($car->id, $locationResponse) && $calculatedPrice == $totalPrice) {
            // $car->id is included in both arrays
            $valid =  true;
        }

        return response()->json($valid);

    }



}
