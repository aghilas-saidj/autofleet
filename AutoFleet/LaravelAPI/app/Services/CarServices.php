<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Booking;


class CarServices
{



    public function allCars()
    {
        $cars = Car::where('under_maintenance', false)->get();
        return  $cars;
        
    }








    public function carsUnderMaintenance()
    {
        $cars = Car::where('under_maintenance', true)->get();
        return  $cars;
        
    }












    public function updateCar($request, $id)
    {

        // Find the car by ID
        $car = Car::findOrFail($id);


        // Update the car's data
        $car->update([
            'name' => $request['name'] ?? $car->name,
            'type' => $request['type'] ?? $car->type,
            'price_per_day' => $request['price_per_day'] ?? $car->price_per_day,
            'seats' => $request['seats'] ?? $car->seats,
            'description' => $request['description'] ?? $car->description,
            'image_path' => $request['image_path'] ?? $car->image_path,
            'airconditioning' => $request['airconditioning'] ?? $car->airconditioning,
            'Theft_Protection' => $request['Theft_Protection']?? $car->Theft_Protection,
            'bags' => $request['bags'] ?? $car->bags,
            'better_to_know' => $request['better_to_know'] ?? $car->better_to_know,
            'cancellation_policy' => $request['cancellation_policy'] ?? $car->cancellation_policy,
            'collision_damage_waiver' => $request['collision_damage_waiver'] ?? $car->collision_damage_waiver,
            'doors' => $request['doors'] ?? $car->doors,
            'engine_type' => $request['engine_type'] ?? $car->engine_type,
            'fuel_policy' => $request['fuel_policy'] ?? $car->fuel_policy,
            'included_insurance' => $request['included_insurance'] ?? $car->included_insurance,
            'is_unlimited_mileage' => $request['is_unlimited_mileage'] ?? $car->is_unlimited_mileage,
            'refundable_security_deposit' => $request['refundable_security_deposit'] ?? $car->refundable_security_deposit,
            'roadside_assistance' => $request['roadside_assistance'] ?? $car->roadside_assistance,
            'seats' => $request['seats'] ?? $car->seats,
            'third_party_liability' => $request['third_party_liability'] ?? $car->third_party_liability,
            'transmission' => $request['transmission'] ?? $car->transmission,
            'type' => $request['type'] ?? $car->type,
            'under_maintenance' => $request['under_maintenance'] ?? $car->under_maintenance,    
            'image_path' => $request['image_path'] ?? $car->image_path, // Now handles image update
        ]);

        return $car;
    }











    public function addCar($data)
    {
        // Create new car entry
        return Car::create([
            'name' => $data['name'],
            'type' => $data['type'],
            'price_per_day' => $data['price_per_day'],
            'doors' => $data['doors'],
            'bags' => $data['bags'],
            'seats' => $data['seats'],
            'Theft_Protection' => $data['Theft_Protection'],
            'airconditioning' => $data['airconditioning'],
            'better_to_know' => $data['better_to_know'],
            'cancellation_policy' => $data['cancellation_policy'],
            'collision_damage_waiver' => $data['collision_damage_waiver'],
            'engine_type' => $data['engine_type'],
            'fuel_policy' => $data['fuel_policy'],
            'included_insurance' => $data['included_insurance'],
            'is_unlimited_mileage' => $data['is_unlimited_mileage'],
            'refundable_security_deposit' => $data['refundable_security_deposit'],
            'roadside_assistance' => $data['roadside_assistance'],
            'third_party_liability' => $data['third_party_liability'],
            'under_maintenance' => false,
            'transmission' => $data['transmission'],
            'description' => $data['description'] ?? null,
            'image_path' => $data['image_path'] ?? null,
        ]);
    }



















    public function deleteCar($id)
    {
        // Find the car by ID
        $car = Car::findOrFail($id);

        // Delete the car
        $car->delete();
    }    















    public function getCarById($id)
    {
        // Fetch the car by ID
        return Car::find($id);
    }

















    public function totalCars()
    {
        return Car::count(); // Get the total number of cars in the database
    }









    public function totalCarsUnderManitenance()
    {
        $cars = Car::where('under_maintenance', true)->get()->count();
        return  $cars;   
    
    }











    
    public function rentedCars()
    {
        // Get all unique car IDs from bookings where the booking date is today or in the future
        return Booking::where('end_date', '>=', now()) // Assuming 'booking_date' is the field for the booking
            ->distinct('car_id')                           // Ensure only unique car IDs are counted
            ->count('car_id');                             // Count the unique car IDs
    }


}
