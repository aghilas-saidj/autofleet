<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CarServices;
use App\Services\infoConfirmationBeforeBookingService;

use App\Helpers\CalculatePrice;
use App\Helpers\CarsLocations;


class CarDetailsController extends Controller
{
    protected $carService;
    protected $calculateprice;
    protected $carslocations;
    protected $infoconfirmationbeforebookingservice;

    public function __construct(CarServices $carService, CalculatePrice $calculateprice , CarsLocations $carslocations, infoConfirmationBeforeBookingService $infoconfirmationbeforebookingservice ) {

        $this->carService = $carService;
        $this->calculateprice = $calculateprice;
        $this->carslocations = $carslocations;
        $this->infoconfirmationbeforebookingservice = $infoconfirmationbeforebookingservice;

    }












    public function get($carId, $fromDate, $toDate, $pickupLocation, $dropoffLocation)
    {

        $car = $this->carService->getCarById($carId);



        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }
        


        $location_response = $this->carslocations->getcars($pickupLocation, $dropoffLocation);
        $locationIds = $location_response['ids'] ?? [];








        // Check if the CarId exists in the locationIds array
        if (!in_array($carId, $locationIds)) {
            return response()->json(['message' => 'Car not available at the selected locations'], 200); // sould be 422 to throw an error in the frontend
        }

        


        $calculatedPriceResponse = $this->calculateprice->BookingPrice($fromDate, $toDate, $carId);



        $isPickupLocationSelected = True;
        $isDropoffLocationSelected = True;



        $pickupsLocationNameList = [];
        $dropoffsLocationNameList = [];




        if ($pickupLocation == 'any') {
            $isPickupLocationSelected = false;
            $pickupsLocationNameList = $this->carslocations->getCarPickups($carId);
        }

        if ($dropoffLocation == 'any') {
            $isDropoffLocationSelected = false;
            $dropoffsLocationNameList = $this->carslocations->getCarDropoffs($carId);
        }




        $data = $calculatedPriceResponse->getData(); // If it's an object
        $totalPrice = $data->total_price;




        $confirmation = $this -> infoconfirmationbeforebookingservice->Confirm($carId, $fromDate, $toDate, $pickupLocation, $dropoffLocation, $totalPrice);



      //  return $confirmation;



        
        return ['confirmation' => $confirmation,'car'=>$car,'totalPrice'=>$calculatedPriceResponse,'isPickupLocationSelected'=>$isPickupLocationSelected,'isDropoffLocationelected'=>$isDropoffLocationSelected , 'PickupLocations'=> $pickupsLocationNameList, 'dropoffsLocations'=>$dropoffsLocationNameList];
    }


}
