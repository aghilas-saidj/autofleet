<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\CarServices;
use Illuminate\Support\Facades\Storage;
use App\Services\UnavailabilityService;
use App\Services\AvailabilityService;

use App\Helpers\DashboardMetrics\FleetMetrics;


use Aws\S3\S3Client;
use Aws\Credentials\Credentials;

class CarController extends Controller
{


    protected $carService;
    protected $unavailabilityService;
    protected $fleetmetrics;




    public function __construct( FleetMetrics $fleetmetrics,CarServices $carService, UnavailabilityService $unavailabilityService) {

        $this->carService = $carService;
        $this->unavailabilityService = $unavailabilityService;

        $this->fleetmetrics = $fleetmetrics;

    }
    










    public function getAllcars() {


        $cars = $this->carService->allCars();
        return $cars;

        }










    public function getCarById($car_id)
    {
        $car = $this->carService->getCarById($car_id);

        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }
        
        $car->load('images');
    
    return response()->json([
        'car' => $car,
        'images' => $car->images,
    ], 200);

    }
















    public function addCar(Request $request)
    {

       
        $validatedData = $request->validate([
            'name' => 'nullable|sometimes|string|max:255',
            'type' => 'nullable|sometimes|string|max:255',
            'price_per_day' => 'nullable|sometimes|numeric',
            'seats' => 'nullable|sometimes|integer',
            'description' => 'nullable|string',     
            'bags' => 'nullable|sometimes|integer',        
            'doors' => 'nullable|sometimes|integer',        
            'airconditioning' => 'nullable|integer',        
            'transmission' => 'nullable|sometimes|string|max:255',        
            'engine_type' => 'nullable|sometimes|string|max:255',        
            'refundable_security_deposit' => 'nullable|sometimes|numeric',        
            'included_insurance' => 'nullable|sometimes|string|max:255',        
            'fuel_policy' => 'nullable|sometimes|string|max:255',        
            'is_unlimited_mileage' => 'nullable|integer',        
            'collision_damage_waiver' => 'nullable|sometimes|string|max:255',        
            'Theft_Protection' => 'nullable|sometimes|string|max:255',        
            'roadside_assistance' => 'nullable|sometimes|string|max:255',        
            'third_party_liability' => 'nullable|sometimes|string|max:255',        
            'better_to_know' => 'nullable|sometimes|string|max:255',        
            'cancellation_policy' => 'nullable|sometimes|string|max:255',                 
        
        ]);





        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('images', $imageName, [
            'disk' => 's3',
            'visibility' => 'public',
        ]);
        $request->merge(['image_path' => $path]);






        $newCar = $this->carService->addCar($request);



        return response()->json([
            'message' => 'Car added successfully!',
            'car' => $newCar,
        ], 201);
    }


























    public function updateCar(Request $request, $id)
    {


        if ($request->hasFile('image')) {
  
        // $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        // $request->file('image')->storeAs('images', $imageName, 'public');
        // $request->merge(['image_path' => 'images/'.$imageName]);



        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('images', $imageName, [
            'disk' => 's3',
            'visibility' => 'public',
        ]);
        $request->merge(['image_path' => $path]);




        }

        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'nullable|sometimes|string|max:255',
            'type' => 'nullable|sometimes|string|max:255',
            'price_per_day' => 'nullable|sometimes|numeric',
            'seats' => 'nullable|sometimes|integer',
            'description' => 'nullable|string',     
            'bags' => 'nullable|sometimes|integer',        
            'doors' => 'nullable|sometimes|integer',        
            'airconditioning' => 'nullable|integer',        
            'transmission' => 'nullable|sometimes|string|max:255',        
            'engine_type' => 'nullable|sometimes|string|max:255',        
            'refundable_security_deposit' => 'nullable|sometimes|numeric',       
            'included_insurance' => 'nullable|sometimes|string|max:255',        
            'fuel_policy' => 'nullable|sometimes|string|max:255',        
            'is_unlimited_mileage' => 'nullable|integer',         
            'collision_damage_waiver' => 'nullable|sometimes|string|max:255',        
            'Theft_Protection' => 'nullable|sometimes|string|max:255',        
            'roadside_assistance' => 'nullable|sometimes|string|max:255',        
            'third_party_liability' => 'nullable|sometimes|string|max:255',        
            'better_to_know' => 'nullable|sometimes|string|max:255',        
            'cancellation_policy' => 'nullable|sometimes|string|max:255',                 
        
        ]);




        // Call the service to update the car
        $updatedCar = $this->carService->updateCar($request, $id);


        return response()->json([
            'message' => 'Car updated successfully!',
            'car' => $updatedCar,
        ], 200);
    }
































    public function deleteCar($id)
    {
        // Delegate deletion to the service
        $this->carService->deleteCar($id);

        return response()->json([
            'message' => 'Car deleted successfully!'
        ], 200);
    }



























        public function getCarsUnderMaintenance()
        {
            $cars = $this->carService->carsUnderMaintenance();
            return $cars;
        }























    public function transferCarToMaintenance($id)
    {


        $data = [
            'under_maintenance' => true,
        ];
        // Call the service to update the car
        $updatedCar = $this->carService->updateCar($data, $id);


        return response()->json([
            'message' => 'Car transferred to maintenance successfully!',
            'car' => $updatedCar,
        ], 200);
    }


































    public function makeCarAvailable($id)
    {


        $data = [
            'under_maintenance' => false,
        ];
        // Call the service to update the car
        $updatedCar = $this->carService->updateCar($data, $id);


        return response()->json([
            'message' => 'Car transferred to maintenance successfully!',
            'car' => $updatedCar,
        ], 200);
    }

}
