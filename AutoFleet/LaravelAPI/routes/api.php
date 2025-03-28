<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Management\UserController;
use App\Http\Controllers\Management\CarController;
use App\Http\Controllers\Management\AvailabilityController;
use App\Http\Controllers\Management\PickupController;
use App\Http\Controllers\Management\DropoffController;
use App\Http\Controllers\Management\LocationController;
use App\Http\Controllers\Management\BookingController;
use App\Http\Controllers\Management\PaymentController;
use App\Http\Controllers\Management\UnavailabilityController;
use App\Http\Controllers\Management\ExpenseController;
use App\Http\Controllers\Management\DashboardController;

use App\Http\Controllers\CarDetailsController;
use App\Http\Controllers\SearchCarsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ManageMyBookingController;
use App\Http\Controllers\PaymentProcessController;

use App\Http\Controllers\PaymentStatusController;

use App\Http\Controllers\GetAvailabilityAndUnavailabilityByCarIdController;
use App\Http\Controllers\CheckBookingInformationController;
use App\Http\Controllers\LoginFormController;
use App\Http\Controllers\RegisterFormController;

use App\Http\Controllers\ContactusController;


use App\Http\Middleware\CheckAdminRole;
use App\Http\Middleware\CheckOwner;

Route::middleware('auth:sanctum',CheckAdminRole::class)->group(function () {


	Route::get('/dash', [DashboardController::class, 'get']);



	Route::get('/management/users', [UserController::class, 'index']);
	Route::post('/management/users', [UserController::class, 'store']);
	Route::get('/management/users/{id}', [UserController::class, 'show']);
	Route::put('/management/users/{id}', [UserController::class, 'update']);
	Route::delete('/management/users/{id}', [UserController::class, 'destroy']);
	
	
	
	
	
	

	Route::get('/management/expenses', [ExpenseController::class, 'index']);  // Get all expenses
	Route::post('/management/expenses', [ExpenseController::class, 'store']);  // Create a new expense
	Route::get('/management/expenses/{id}', [ExpenseController::class, 'show']);  // Get a specific expense by ID
	Route::put('/management/expenses/{id}', [ExpenseController::class, 'update']);  // Update an expense by ID
	Route::delete('/management/expenses/{id}', [ExpenseController::class, 'destroy']);  // Delete an expense by ID
	
	

	


	Route::post('/management/locations', [LocationController::class, 'store']);
	Route::put('/management/locations/{id}', [LocationController::class, 'update']);
	Route::delete('/management/locations/{id}', [LocationController::class, 'destroy']);
	



	Route::get('/management/{id}/pickupsanddropoffsbycarId', [LocationController::class, 'pickupsAndDropoffsByCarId']);
	Route::post('/management/{id}/addpickup', [LocationController::class, 'addCarPickup']);
	Route::post('/management/{id}/adddropoff', [LocationController::class, 'addCarDropoff']);





	Route::delete('/management/deletepickup/{id}', [LocationController::class, 'deletePickup']);
	Route::delete('/management/deletepropoff/{id}', [LocationController::class, 'deleteDropoff']);





Route::delete('/management/pickups/{id}', [PickupController::class, 'destroy']);
Route::get('/management/pickups/{id}', [PickupController::class, 'pickupbyid']);
Route::post('/management/pickups', [PickupController::class, 'store']);
Route::get('/management/pickups', [PickupController::class, 'allPickups']);



Route::get('/management/{id}/pickups', [PickupController::class, 'pickupsByCar']);







Route::delete('/management/dropoffs/{id}', [DropoffController::class, 'destroy']);
Route::get('/management/dropoffs/{id}', [DropoffController::class, 'dropoffbyid']);
Route::post('/management/dropoffs', [DropoffController::class, 'store']);
Route::get('/management/dropoffs', [DropoffController::class, 'index']);



Route::get('/management/{id}/dropoffs', [DropoffController::class, 'dropoffsByCar']);





Route::get('/management/getavailabilitybycarid/{id}', [AvailabilityController::class, 'getAvailability']);
Route::post('/management/addcaravailability', [AvailabilityController::class, 'addAvailability']);
Route::delete('/management/removecaravailability/{id}', [AvailabilityController::class, 'RemoveAvailability']);






Route::get('/management/unavailabilities', [UnavailabilityController::class, 'index']);
Route::get('/management/unavailabilities/{id}', [UnavailabilityController::class, 'show']);
Route::post('/management/unavailabilities', [UnavailabilityController::class, 'store']);
Route::put('/management/unavailabilities/{id}', [UnavailabilityController::class, 'update']);
Route::delete('/management/unavailabilities/{id}', [UnavailabilityController::class, 'destroy']);



Route::get('/management/getunavailability/{id}', [UnavailabilityController::class, 'getUnavailability']);






Route::post('/management/cars', [CarController::class, 'addCar']);
Route::post('/management/cars/{id}', [CarController::class, 'updateCar']);
Route::get('/management/cars/{id}', [CarController::class, 'getCarById']);
Route::get('/management/cars', [CarController::class, 'getAllcars']);
Route::delete('/management/cars/{id}', [CarController::class, 'deleteCar']); 

Route::get('/management/cars/{id}/transfertomaintenance', [CarController::class, 'transferCarToMaintenance']);
Route::get('/management/cars/{id}/makecaravailable', [CarController::class, 'makeCarAvailable']);

Route::get('/management/carsundermaintenance', [CarController::class, 'getCarsUnderMaintenance']);








Route::prefix('/management/payments')->group(function () {
	Route::get('/', [PaymentController::class, 'index']); 
	Route::post('/', [PaymentController::class, 'store']);     
	Route::get('/{id}', [PaymentController::class, 'show']);        
   // Route::put('/{id}', [PaymentController::class, 'update']);     
  //  Route::delete('/{id}', [PaymentController::class, 'destroy']);  
});







Route::prefix('/management/bookings')->group(function () {
	Route::post('/', [BookingController::class, 'create']);
	Route::put('{id}', [BookingController::class, 'update']);
	Route::delete('{id}', [BookingController::class, 'destroy']);
	Route::get('/', [BookingController::class, 'index']);
	Route::get('{id}', [BookingController::class, 'show']);
	Route::get('car/{car_id}', [BookingController::class, 'bookingsByCar']);
	Route::get('user/{user_id}', [BookingController::class, 'bookingsByUser']);
	Route::get('status/{status}', [BookingController::class, 'bookingsByStatus']);
	Route::get('date/{start_date}/{end_date}', [BookingController::class, 'bookingsByDateRange']); 
	Route::get('reference/{reference_code}', [BookingController::class, 'bookingByReferenceCode']); 
	Route::get('cancel/{id}', [BookingController::class, 'CancelBooking']);


	
});




});













Route::middleware('auth:sanctum')->get('/cars', [SearchCarsController::class, 'carList']);
Route::get('/guest/cars', [SearchCarsController::class, 'carList']);


Route::middleware('auth:sanctum')->get('/cars/{carId}/{fromDate}/{toDate}/{pickupLocation}/{dropoffLocation}', [CarDetailsController::class, 'get']);
Route::get('/guest/cars/{carId}/{fromDate}/{toDate}/{pickupLocation}/{dropoffLocation}', [CarDetailsController::class, 'get']);

Route::post('/guest/checkout', [PaymentProcessController::class, 'makeAPayment']);
Route::middleware('auth:sanctum')->post('/checkout', [PaymentProcessController::class, 'makeAPayment']);

Route::post('/confirm', [CheckBookingInformationController::class, 'confirm']);




Route::post('/getpaymentstatus', [PaymentStatusController::class, 'getstatus']);


Route::post('/getmybooking', [ManageMyBookingController::class,'getmybooking']);





Route::get('/getcaravailabilityandunavailability/{car_id}', [GetAvailabilityAndUnavailabilityByCarIdController::class, 'getcaravailabilityandunavailability']);

Route::put('/profile/{id}', [UserController::class, 'update'])->middleware('auth:sanctum')->middleware(CheckOwner::class);
Route::get('/profile/{id}', [ProfileController::class, 'getProfile'])->middleware('auth:sanctum')->middleware(CheckOwner::class);



Route::get('/login', [LoginFormController::class, 'getloginform']);
Route::get('/register', [RegisterFormController::class, 'getregisterform']);


Route::get('/locations', [LocationController::class, 'index']);




Route::post('/sendemail', [ContactusController::class, 'sendContactEmail']);



require __DIR__.'/auth.php';