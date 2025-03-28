<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessPayment;
//use App\Models\Car;
//use App\Models\Unavailability;
use App\Models\Payment;
//use App\Models\Booking;

use App\Services\CarServices;
use App\Services\UnavailabilityService;
use App\Services\BookingService;
use App\Services\PaymentService;
use App\Services\infoConfirmationBeforeBookingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentProcessController extends Controller
{

	protected $carservices;
	protected $unavailabilityservice;
	protected $bookingservice;
	protected $paymentservice;
	protected $infoconfirmationbeforebookingservice;



	public function __construct(CarServices $carservices, UnavailabilityService $unavailabilityservice, BookingService $bookingservice, PaymentService $paymentservice, infoConfirmationBeforeBookingService $infoconfirmationbeforebookingservice)
	{
		
	    $this->carservices = $carservices;
		$this->unavailabilityservice = $unavailabilityservice;
		$this->bookingservice = $bookingservice;
		$this->paymentservice = $paymentservice;
        $this -> infoconfirmationbeforebookingservice = $infoconfirmationbeforebookingservice;

	}


    public function makeAPayment(Request $request)
		{

		 



			$request->validate([
				'from' => 'required|date|after_or_equal:today',
				'to' => 'required|date|after:from',
				'car_id' => 'required|integer|exists:cars,id',
				'price' => 'required|string|max:255',
				'pickuplocation' => 'required|string|max:255',
				'dropofflocation' => 'required|string|max:255',
				'emailAddress' => 'required|email',
				'phoneNumber' => ['required', 'regex:/^\+?[0-9]{4,15}$/'],
			]);


			



    // Check if the user is authenticated
    $user = auth()->user();
    if ($user) {
        // If authenticated, you can store the user_id in the booking table
        $user_id = $user->id;
        // Proceed with adding the booking and payment logic for authenticated users
    } else {
        // For unauthenticated users, you might not need to store user_id
        $user_id = null; // Or some other logic for unauthenticated users
    }



		$numericPrice = (float) str_replace(',', '', $request->price);


		

	
			$from = $request->from;
			$to = $request->to;
			$car_id = $request->car_id;
			$price = $numericPrice;
			$uuid = $request->uuid;
			$pickup = $request->pickuplocation;
			$dropoff = $request->dropofflocation;
			$emailAddress = $request->emailAddress;
			$phoneNumber = $request->phoneNumber;



		

			// Validate the email address
			if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {

				return 'email_address_false';
						}

			// Validate the phone number (assuming it should be digits and between 10 and 15 characters)





			if (!preg_match('/^\+?[0-9]+$/', $phoneNumber)) {
				return 'phone_number_false';
			}




			$response = $this -> infoconfirmationbeforebookingservice->Confirm($car_id, $from, $to, $pickup, $dropoff, $price);

			$responseContent = $response->getContent();

		//	$responseContent = json_decode($response, true);

		//	return $response;

			//return $request;


/////Check the error here




			if ($responseContent === 'false') {
				//return 'Invalid request, please try again';
				return 'payment_false';
			}
			




			$bookingData=[		             
				'car_id' => $car_id,
				'start_date' => $from,
				'end_date' => $to,
				'total_price'=>$price,
				'status'=>'pending',
				'email_address'=>$emailAddress,
				'phone_number'=>$phoneNumber,
				'pickuplocation'=>$pickup,
				'dropofflocation'=>$dropoff,
				'reference_code' => substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'), 0, 6),
			];
				// If the user is authenticated, add user_id to the booking data
				if ($user_id) {
					$bookingData['user_id'] = $user_id;
				}

			$booking = $this->bookingservice->createBooking($bookingData);









			$unavailabilityData = [		
				'booking_id' => $booking->id,             
				'car_id' => $car_id,
				'unavailable_from' => $from,
				'unavailable_to' => $to,
				'reason'=>"new booking"
				];

		$unavailability = $this->unavailabilityservice->createUnavailability($unavailabilityData);














			$dataForPaymentCreationInDB = [
								'car_id' => $car_id,
								'booking_id' => $booking->id,
								'amount'=>$price,
								'payment_method'=>$request->paymentMethodId,
								'start_date' => $from,
								'end_date' => $to,
								'reason'=>"new booking",
								'status'=>'pending',
								'uuid'=>$uuid,
								];
			$payment = $this->paymentservice->createPayment($dataForPaymentCreationInDB);







		    // Prepare payment data
		    $dataForPaymentProcessing = [
		    	'uuid'=> $payment->uuid,
		        'amount' => $price,
		        'car_id' => $car_id,
		        'currency' => 'USD',
		        'paymentMethodId' => $request->paymentMethodId,
		        'car_id' => $request->car_id,
	            'start_date' => $request->from,
	            'end_date' => $request->to,
	            'unavailabilityID' => $unavailability->id,

		    ];



		    // Dispatch the job to the queue
		    ProcessPayment::dispatch($dataForPaymentProcessing);


			
			return [
				"message" => "Payment processing initiated.",
				"dataForPaymentProcessing" => $dataForPaymentProcessing,
			];
		}


}