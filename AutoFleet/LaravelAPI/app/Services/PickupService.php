<?php

namespace App\Services;

use App\Models\Pickup;
use App\Models\Car;


use Illuminate\Database\Eloquent\ModelNotFoundException;

class PickupService
{
    protected $pickup;

    public function __construct(Pickup $pickup)
    {
        $this->pickup = $pickup;
    }












    public function getPickupsByLocationId($locationId = null)
    {
        if ($locationId) {
            return $this->pickup->where('location_name', $locationId)->get();
        }

        return $this->pickup->all();
    }
















    public function createPickup(array $data)
    {
        // Validate the data before creating, if needed
        $pickup = Pickup::create($data);

        return $pickup;
    }




















    public function updatePickup($id, array $data)
    {
        $pickup = Pickup::find($id);

        if (!$pickup) {
            throw new ModelNotFoundException('Pickup not found');
        }

        $pickup->update($data);

        return $pickup;
    }


















    public function deletePickup($id)
    {
        $pickup = Pickup::find($id);

        if (!$pickup) {
            throw new ModelNotFoundException('Pickup not found');
        }

        return $pickup->delete();
    }


















    public function getAllPickups()
    {
        return Pickup::all();
    }

















    public function getPickupById($id)
    {
        $pickup = Pickup::find($id);

        if (!$pickup) {
            throw new ModelNotFoundException('Pickup not found');
        }

        return $pickup;
    }








    












    public function getPickupsByCarId($car_id)
    {
        return Pickup::where('car_id', $car_id)->get();
    }

    public function getPickupsWithCarsAndLocations()
    {
        // Fetch all pickups from the database, including the related location and car details
        $pickups = Pickup::with(['location', 'car'])->get();

        // Return the pickups as a JSON response
        return response()->json($pickups);
    }











    














    public function getPickupsByCar($carId)
{
    $car = Car::with('pickups.location')->findOrFail($carId);
    return response()->json($car->pickups);
}



}
