<?php

namespace App\Services;

use App\Models\Dropoff;
use App\Models\Car;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DropoffService
{
    protected $dropoff;

    public function __construct(Dropoff $dropoff)
    {
        $this->dropoff = $dropoff;
    }









    public function getDropoffsByLocationId($locationId = null)
    {
        if ($locationId) {
            return $this->dropoff->where('location_name', $locationId)->get();
        }

        return $this->dropoff->all();
    }






    public function createDropoff(array $data)
    {
        // Validate the data before creating, if needed
        $dropoff = Dropoff::create($data);

        return $dropoff;
    }












    public function updateDropoff($id, array $data)
    {
        $dropoff = Dropoff::find($id);

        if (!$dropoff) {
            throw new ModelNotFoundException('Dropoff not found');
        }

        $dropoff->update($data);

        return $dropoff;
    }













    public function deleteDropoff($id)
    {
        $dropoff = Dropoff::find($id);

        if (!$dropoff) {
            throw new ModelNotFoundException('Dropoff not found');
        }

        return $dropoff->delete();
    }













    public function getAllDropoffs()
    {
        return Dropoff::all();
    }













    public function getDropoffById($id)
    {
        $dropoff = Dropoff::find($id);

        if (!$dropoff) {
            throw new ModelNotFoundException('Dropoff not found');
        }

        return $dropoff;
    }








    public function getDropoffsByCarId($car_id)
    {
        return Dropoff::where('car_id', $car_id)->get();
    }









    


    public function getDropoffsByCar($carId)
    {
        $car = Car::with('dropoffs.location')->findOrFail($carId);
        return response()->json($car->dropoffs);
    }
    
}
