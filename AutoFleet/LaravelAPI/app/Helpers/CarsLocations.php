<?php

namespace App\Helpers;

use App\Services\PickupService;
use App\Services\DropoffService;
use App\Services\LocationService;

class CarsLocations
{
    protected $pickupService;
    protected $dropoffService;
    protected $locationService;

    public function __construct(
        PickupService $pickupService,
        DropoffService $dropoffService,
        LocationService $locationService
    ) {
        $this->pickupService = $pickupService;
        $this->dropoffService = $dropoffService;
        $this->locationService = $locationService;
    }

    public function getCars($pickup = null, $dropoff = null)
    {
        
        
        
        
     $checkPickups = $this->locationService->getLocationIdByName($pickup);
     $checkDropoff = $this->locationService->getLocationIdByName($dropoff);







     if ($pickup != 'any' && is_null($checkPickups)) {
        return False;
     }

     if ($dropoff != 'any' && is_null($checkDropoff)) {
        return False;
     }


    if ($pickup == 'any') {
        $pickups = $this->pickupService->getAllPickups();
    }

    else
    {
        $pickupLocationId = $this->locationService->getLocationIdByName($pickup);
        $pickups = $this->pickupService->getPickupsByLocationId($pickupLocationId);

    }


    if ($dropoff == 'any') {
        $dropoffs = $this->dropoffService->getAllDropoffs();
    }

    else
    {
        $dropoffLocationId = $this->locationService->getLocationIdByName($dropoff);
        $dropoffs = $this->dropoffService->getDropoffsByLocationId($dropoffLocationId);

    }



        // Fetch pickups and dropoffs





        // Extract car IDs and find the intersection
        $pickupIds = $pickups->pluck('car_id')->toArray();
        $dropoffIds = $dropoffs->pluck('car_id')->toArray();

        //$intersectionIds = array_intersect($pickupIds, $dropoffIds);
        $intersectionIds = array_values(array_intersect($pickupIds, $dropoffIds));

    

        return [
            'ids' => $intersectionIds
        ];
    }


    public function getCarPickups($carId)
    {
        $pickupsLocationNameList = [];

        $pickups = $this->pickupService->getPickupsByCarId($carId);
        
        foreach ($pickups as $pickup) {
            $pickupsLocationNameList[] = $this->locationService->getLocationById($pickup['location_id']);   
        }

        return $pickupsLocationNameList;

    }

    public function getCarDropoffs($carId)
    {
        $dropoffsLocationNameList = [];
        $dropoffs = $this->dropoffService->getDropoffsByCarId($carId);
        foreach ($dropoffs as $dropoff) {
            $dropoffsLocationNameList[] = $this->locationService->getLocationById($dropoff['location_id']);
        }
        return $dropoffsLocationNameList;

    }















    
}
