<?php

namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use App\Services\UnavailabilityService;

use Illuminate\Support\Carbon;



class UnavailabilityController
{
    protected $unavailabilityService;

    public function __construct(UnavailabilityService $unavailabilityService)
    {
        $this->unavailabilityService = $unavailabilityService;
    }
























    public function addUnavailability(Request $request)
    {

		$data = [
		            'car_id' => $request->car_id,
		            'start_date' => $request->from,
		            'end_date' => $request->to,
		            'reason'=>$request->reason
		            ];

		$unavailability = $this->unavailabilityService->createUnavailability($data);


        // Optionally return a response
        return response()->json(['message' => 'Unavailability created successfully', 'data' => $unavailability], 201);

    }





















    public function RemoveUnavailability($id)
    {

		$unavailability = $this->unavailabilityService->deleteUnavailability($id);

	    return response()->json(['message' => 'Unavailability deleted successfully'], 200);
	   
    }




























    public function getUnavailability($id)
    {

		$unavailability = $this->unavailabilityService->getUnavailabilityByCarId($id);

	    return $unavailability;
	   
    }








    


}
