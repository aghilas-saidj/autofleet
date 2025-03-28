<?php

namespace App\Services;

use App\Models\Pickup;
use App\Models\Dropoff;


use App\Models\Location;
use App\Models\Car;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class LocationService
{
    protected $location;

    public function __construct(Location $location)
    {
        $this->location = $location;
    }










    public function getLocationIdByName($name)
    {
        $location = $this->location->where('name', $name)->first();
        return $location ? $location->name : null;
    }












    public function updateLocation($id, array $data)
    {
        $location = Location::find($id);

        if (!$location) {
            throw new ModelNotFoundException('Location not found');
        }

        $location->update($data);

        return $location;
    }

















    public function deleteLocation($id)
    {
        $location = Location::find($id);

        if (!$location) {
            throw new ModelNotFoundException('Location not found');
        }

        return $location->delete();
    }












    public function getAllLocations()
    {
        return Location::all();
    }













    public function getLocationById($id)
    {
        $location = Location::find($id);

        if (!$location) {
            throw new ModelNotFoundException('Location not found');
        }

        return $location;
    }











    public function getPickupsAndDropoffsByCarID($carId)
    {
        $car = Car::with(['pickups.location', 'dropoffs.location'])->findOrFail($carId);
    
        $data = [
            'pickups' => $car->pickups,
            'dropoffs' => $car->dropoffs,
        ];
    
        return response()->json($data);
    }




    public function addPickup($request, $carId)
    {

    
        try {
            DB::beginTransaction();
    
            // Step 1: Create the location
            $location = Location::create([
                'name' => $request->name,
                'address' => $request->address,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
            ]);
    
            // Step 2: Create the pickup with the new location ID and car ID
            $pickup = Pickup::create([
                'car_id' => $carId,
                'location_id' => $location->id,
                'location_name' => $location->name,
            ]);

    
            DB::commit(); // Commit if both queries succeed
    
            return response()->json([
                'message' => 'Pickup added successfully!',
                'pickup' => $pickup->load('location') // Include location details in response
            ], 201);
    
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback if any query fails
            return response()->json(['error' => 'Failed to add pickup.'.$e], 500);
        }
    }













    public function addDropoff($request, $carId)
    {

    
        try {
            DB::beginTransaction();
    
            // Step 1: Create the location
            $location = Location::create([
                'name' => $request->name,
                'address' => $request->address,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
            ]);
    
            // Step 2: Create the pickup with the new location ID and car ID
            $dropoff = Dropoff::create([
                'car_id' => $carId,
                'location_id' => $location->id,
                'location_name' => $location->name,
            ]);
    
            DB::commit(); // Commit if both queries succeed
    
            return response()->json([
                'message' => 'Dropoff added successfully!',
                'dropoff' => $dropoff->load('location') // Include location details in response
            ], 201);
    
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback if any query fails
            return response()->json(['error' => 'Failed to add dropoff.'.$e], 500);
        }
    }











    public function deletePickup($id)
    {
        $pickup = Pickup::find($id);

        if (!$pickup) {
            throw new ModelNotFoundException('Pickup not found');
        }

        return $pickup->delete();
    }


    public function deleteDropoff($id)
    {
        $dropoff = Dropoff::find($id);

        if (!$dropoff) {
            throw new ModelNotFoundException('Dropoff not found');
        }

        return $dropoff->delete();
    }

}
