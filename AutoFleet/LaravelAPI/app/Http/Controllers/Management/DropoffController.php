<?php

namespace App\Http\Controllers\Management;

use App\Models\Dropoff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\DropoffService;

class DropoffController
{
	
    protected $dropoffservice;

    public function __construct(DropoffService $dropoffservice)
    {
        $this->dropoffservice = $dropoffservice;
    }














    public function dropoffbyid($id)
    {
        $dropoff = $this->dropoffservice->getDropoffById($id);
        return response()->json($dropoff);
    }
















    public function index()
    {
        // Retrieve all dropoffs with the associated location and car details
        $dropoffs = $this->dropoffservice->getAllDropoffs();
        return response()->json($dropoffs);
         
    }
















    /**
     * Store a new dropoff.
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'location_id' => 'required|exists:locations,id',
            'car_id' => 'required|exists:cars,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


		$data = [
		      'location_id' => $request->location_id,
		      'car_id' => $request->car_id,
		        ];

        $dropoff = $this->dropoffservice->createDropoff($data);

        return response()->json($dropoff, 201);
    }
















    /**
     * Update an existing dropoff.
     */
    public function update(Request $request, $id)
    {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'location_id' => 'required|exists:locations,id',
            'car_id' => 'required|exists:cars,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


		$data = [
		            'location_id' => $request->location_id,
		            'car_id' => $request->car_id,
		            ];
        

        $dropoff = $this->dropoffservice->updateDropoff($id,$data);

        return response()->json($dropoff);
    }


























    


    /**
     * Delete a dropoff.
     */
    public function destroy($id)
    {

    	$dropoff = $this->dropoffservice->deleteDropoff($id);
    	return response()->json($dropoff);
    }



























    public function dropoffsByCar($id)
    {

    	$dropoff = $this->dropoffservice->getDropoffsByCar($id);
        // Return the pickups as a JSON response
        return response()->json($dropoff);
    }








}
