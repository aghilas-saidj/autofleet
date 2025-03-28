<?php

namespace App\Helpers;

use App\Services\CarServices;

/**
 * 
 */
class CalculatePrice
{
	
    protected $carService;

    public function __construct(CarServices $carService) {
        $this->carService = $carService;

    }

	public function BookingPrice($from, $to, $car_id)
	{



		$dateFormat = 'Y-m-d H:i';

		// Check if the 'from' date is in the correct format
		if ($from && !\DateTime::createFromFormat($dateFormat, $from)) {
			return response()->json(['message' => 'Invalid "from" date format. Expected format: YYYY-MM-DD HH:MM from price calculation' , 'calculated' => False], 422);
		}
	
		// Check if the 'to' date is in the correct format
		if ($to && !\DateTime::createFromFormat($dateFormat, $to)) {
			return response()->json(['message' => 'Invalid "to" date format. Expected format: YYYY-MM-DD HH:MM from price calculation', 'calculated' => False], 422);
		}







		//$car = Car::find($car_id);
		$car = $this->carService->getCarById($car_id);

		$pricePerDay = $car->price_per_day;

		$date1 = new \DateTime($from);

		$date2 = new \DateTime($to);

		// Calculate the difference in seconds
		$interval = $date1->diff($date2);
		$seconds = ($interval->days * 24 * 60 * 60) +  // Total days in seconds
		           ($interval->h * 60 * 60) +          // Total hours in seconds
		           ($interval->i * 60) +               // Total minutes in seconds
		           $interval->s;                       // Remaining seconds

		// Convert seconds to days as a float
		$days = $seconds / (24 * 60 * 60);

		$total_price = $days * $pricePerDay;
		$total_price = number_format($total_price, 2);

	//	echo "Number of days: " . number_format($days, 2) . " => the total price is: " . $total_price;


		return response()->json(['total_price'=>$total_price, 'booking_period'=>$interval]);



		//Calculate the number of days
		//Get the price per
		//

		//Return data the car details , and the dates and the details about the price

	}
}