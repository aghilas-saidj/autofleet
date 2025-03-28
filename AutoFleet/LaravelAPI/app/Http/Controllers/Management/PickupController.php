<?php

namespace App\Http\Controllers\Management;

use App\Models\Pickup;
use App\Models\Car;

use App\Services\PickupService;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PickupController
{


    protected $pickupservice;

    public function __construct(PickupService $pickupservice)
    {
        $this->pickupservice = $pickupservice;
    }




















    public function allPickups()
    {
        $pickups = $this->pickupservice->getAllPickups();
        return response()->json($pickups);
    }


















    

    public function pickupbyid($id)
    {
        $pickup = $this->pickupservice->getPickupById($id);
        return response()->json($pickup);
    }

    
























    /**
     * Get all pickups.
     */
    public function index()
    {

    	$pickups = $this->pickupservice->getPickupsWithCarsAndLocations();
        // Return the pickups as a JSON response
        return response()->json($pickups);
    }























    /**
     * Add a new pickup.
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'location_id' => 'required|exists:locations,id', // Ensure location exists
            'car_id' => 'required|exists:cars,id', // Ensure car exists
        ]);

        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create the new pickup entry

        $data=[            

        	'location_id' => $request->location_id,
            'car_id' => $request->car_id
        ];


    	$pickup = $this->pickupservice->createPickup($data);

        // Return the newly created pickup as a JSON response
        return response()->json($pickup, 201);
    }






























    /**
     * Update an existing pickup by ID.
     */
    public function update(Request $request, $id)
    {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'location_id' => 'required|exists:locations,id', // Ensure location exists
            'car_id' => 'required|exists:cars,id', // Ensure car exists
        ]);

        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }



		$data = [
			        'location_id' => $request->location_id,
		            'car_id' => $request->car_id,
		        ];

    	$pickup = $this->pickupservice->updatePickup($id,$data);

        // Return the updated pickup as a JSON response
        return response()->json($pickup);
    }


























    /**
     * Delete a pickup by ID.
     */
    public function destroy($id){

    	$pickup = $this->pickupservice->deletePickup($id);

        // Return a success message
        return response()->json(['message' => 'Pickup deleted successfully']);
    }



























    
    public function pickupsByCar($id)
    {

    	$pickups = $this->pickupservice->getPickupsByCar($id);
        // Return the pickups as a JSON response
        return response()->json($pickups);
    }


    




    


}
