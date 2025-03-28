<?php

namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\LocationService;

class LocationController
{


    protected $locationservice;

    public function __construct(LocationService $locationservice)
    {
        $this->locationservice = $locationservice;
    }








    public function index()
    {
        // Fetch all locations from the database

        $locations = $this->locationservice->getAllLocations();

        // Return the locations as a JSON response
        return response()->json($locations);
    }

















    /**
     * Add a new location.
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'latitude' => 'nullable|string|max:255',
            'longitude' => 'nullable|string|max:255',
        ]);

        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

		$data =[
		            'name' => $request->name,
		            'address' => $request->address,
		            'latitude' => $request->latitude,
		            'longitude' => $request->longitude,
		            ];


        // Create the new location
        $location = $this->locationservice->createLocation($data);

        return response()->json($location, 201);
    }



























    /**
     * Update an existing location by ID.
     */
    public function update(Request $request, $id)
    {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'latitude' => 'nullable|string|max:255',
            'longitude' => 'nullable|string|max:255',
        ]);

        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


		$data =[
		            'name' => $request->name,
		            'address' => $request->address,
		            'latitude' => $request->latitude,
		            'longitude' => $request->longitude,
		            ];


        $location = $this->locationservice->updateLocation($id, $data);



        // Return the updated location as a JSON response
        return response()->json($location);
    }

























    /**
     * Delete a location by ID.
     */
    public function destroy($id)
    {
        // Find the location by its ID
        $location = $this->locationservice->deleteLocation($id);

        // Return a success message
        return response()->json(['message' => 'Location deleted successfully']);
    }




















    public function  locationbyid($id)
    {
	    $location = $this->locationservice->getLocationById($id);
	    return response()->json($location); 

    }





    /////////////////////////////////////////////////////////////

















    public function deletePickup($id)
    {
        // Find the location by its ID
        $location = $this->locationservice->deletePickup($id);

        // Return a success message
        return response()->json(['message' => 'Pickup deleted successfully']);
    }

























    public function deleteDropoff($id)
    {
        // Find the location by its ID
        $location = $this->locationservice->deleteDropoff($id);

        // Return a success message
        return response()->json(['message' => 'Dropoff deleted successfully']);
    }























    public function  pickupsAndDropoffsByCarId($car_id)
    {
	    $locations = $this->locationservice->getPickupsAndDropoffsByCarID($car_id);
	    return response()->json($locations); 

    }

    
























    public function addCarPickup(Request $request, $car_id)
    {

    	$pickups = $this->locationservice->addPickup($request, $car_id);
        // Return the pickups as a JSON response
        return response()->json($pickups);
    }


























    

    public function addCarDropoff(Request $request, $car_id)
    {

    	$dropoff = $this->locationservice->addDropoff($request, $car_id);
        // Return the pickups as a JSON response
        return response()->json($dropoff);
    }

    

}
