<?php

namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;

use App\Services\AvailabilityService;

use Illuminate\Support\Carbon;

class AvailabilityController
{

 
    protected $availabilityService;

    public function __construct(AvailabilityService $availabilityService)
    {
        $this->availabilityService = $availabilityService;
    }






    public function addAvailability(Request $request)
    {

        
       // ✅Validate First, Then Assign Values

        $request->validate([
            'car_id' => 'required|integer|exists:cars,id',
            'available_from' => 'required|date|after_or_equal:today',
            'available_to' => 'required|date|after:available_from',
        ]);




    $data = ['car_id' => $request->car_id,
            'available_from' => $request->available_from,
            'available_to' => $request->available_to];



    $availability = $this->availabilityService->createAvailability($data);


        // Optionally return a response
        return response()->json(['message' => 'Availability created successfully', 'data' => $availability], 201);



    }








    public function RemoveAvailability($id)
    {

    	$availability = $this->availabilityService->deleteAvailability($id);
    	return $availability;


    }







    public function getAvailability($id)
    {

    	$availability = $this->availabilityService->getAvailabilityByCarId($id);
    	return $availability;


    }


}
