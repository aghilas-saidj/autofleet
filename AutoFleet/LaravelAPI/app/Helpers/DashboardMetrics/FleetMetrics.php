<?php


namespace App\Helpers\DashboardMetrics;

use App\Services\CarServices;


class FleetMetrics
{
     
    protected $carservices;

    public function __construct(CarServices $carservices) {
        $this->carservices = $carservices;
    }



    public function get()
    {

        $totalCars = $this->carservices->totalCars();
        $carsUnderMaintenance = $this->carservices->totalCarsUnderManitenance();
        $operativeCars = $totalCars - $carsUnderMaintenance;
        $rentedCars = $this->carservices->rentedCars(); // Currently rented cars
        $onStokCars =  $operativeCars - $rentedCars;


        return response()->json([
            'total_cars' => $totalCars,
            'cars_under_maintenance'=>$carsUnderMaintenance,
            'operative_cars'=>$operativeCars,
            'rented_Cars'=>$rentedCars,
            'on_stock_cars'=>$onStokCars,
        ]);


        
    }





}
