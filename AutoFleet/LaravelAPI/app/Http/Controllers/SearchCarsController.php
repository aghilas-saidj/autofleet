<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Helpers\GetCarsbyDates;
use App\Helpers\CarsLocations;



class SearchCarsController extends Controller
{

    protected $getcarsbydates;
    protected $carslocations;


    public function __construct(GetCarsbyDates $getcarsbydates , CarsLocations $carslocations) {
        $this->getcarsbydates = $getcarsbydates;
        $this->carslocations = $carslocations;

    }

    public function carList(Request $request)
    {

        // Validate the incoming request data
        $validatedData = $request->validate([
            'from' => 'required|date|after_or_equal:today', // Ensure 'from' is a valid date and not in the past
            'to' => 'required|date|after:from',             // Ensure 'to' is a valid date and after 'from'
            'pickup' => 'required|string',                 // Ensure 'pickup' is a string
            'dropoff' => 'required|string',                // Ensure 'dropoff' is a string
        ]);



        // Access validated data
        $from = $validatedData['from'];
        $to = $validatedData['to'];
        $pickup = $validatedData['pickup'];
        $dropoff = $validatedData['dropoff'];







        $location_response = $this->carslocations->getcars($pickup, $dropoff);
        $date_response = $this->getcarsbydates->getCarsWithAvailability($from, $to);



        
        if (!is_array($location_response)) {
            // It's an array
            dd('Location response is not an array', $location_response);
        }






        // Extract IDs from $location_response
        $location_ids = $location_response['ids'];
        // Convert $date_response JsonResponse into an array
        $date_data = json_decode($date_response->getContent(), true); // Decode JSON content to an associative array






        // Filter the $date_data to include only cars with car_id in $location_ids
        $filtered_date_response = array_filter($date_data, function ($car) use ($location_ids) {
            return in_array($car['car_id'], $location_ids);
        });



        

        // Return or process the filtered result
        return array_values($filtered_date_response); // Reset array keys for a clean response
        

    }



}
