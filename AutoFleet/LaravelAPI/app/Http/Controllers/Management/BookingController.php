<?php

namespace App\Http\Controllers\Management;

use App\Services\BookingService;
use App\Services\UnavailabilityService;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookingController
{
    protected $bookingService;
    protected $unavailabilityService;

    public function __construct(BookingService $bookingService, UnavailabilityService $unavailabilityService)
    {
        $this->bookingService = $bookingService;
        $this->unavailabilityService = $unavailabilityService;

    }














    public function create(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'integer',
            'car_id' => 'required|integer',
            'total_price' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|string',
            'reference_code' => 'required|string',
			'email_address' => 'string',
            'type' => 'required|string',
            'additional_info' => 'required|string',
        ]);


        $booking = $this->bookingService->createBooking($data);

        return response()->json($booking, 201);
    }

















    public function update($id, Request $request)
    {
        $data = $request->validate([
            'user_id' => 'integer',
            'car_id' => 'integer',
            'total_price' => 'numeric',
            'start_date' => 'date',
            'end_date' => 'date',
            'status' => 'string',
            'reference_code' => 'string',
			'email_address' => 'string',
            'type' => 'string',
            'additional_info' => 'string',
        ]);

        try {
            $booking = $this->bookingService->updateBooking($id, $data);
            return response()->json($booking, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }


















    public function destroy($id)
    {
        try {
            $this->bookingService->deleteBooking($id);
            return response()->json(['message' => 'Booking deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }















    public function index()
    {
        $bookings = $this->bookingService->getAllBookings();
        return response()->json($bookings, 200);
    }



















    public function show($id)
    {
        try {
            $booking = $this->bookingService->getBookingById($id);
            return response()->json($booking, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }














    public function bookingsByCar($car_id)
    {
        $bookings = $this->bookingService->getBookingsByCar($car_id);
        return response()->json($bookings, 200);
    }


















    public function bookingsByUser($user_id)
    {
        $bookings = $this->bookingService->getBookingsByUser($user_id);
        return response()->json($bookings, 200);
    }















    public function bookingsByStatus($status)
    {
        $bookings = $this->bookingService->getBookingsByStatus($status);
        return response()->json($bookings, 200);
    }














    public function bookingsByDateRange($start_date, $end_date)
    {
        $bookings = $this->bookingService->getBookingsByDateRange($start_date, $end_date);
        return response()->json($bookings, 200);
    }

















    public function bookingByReferenceCode($reference_code)
    {
        try {
            $booking = $this->bookingService->getBookingByReferenceCode($reference_code);
            return response()->json($booking, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
















    public function getAllCustomers()
    {


        $numberOfAllCustomers = $this->bookingService->countAllCustomers();

        return response()->json([
            'number_of_all_customers' => $numberOfAllCustomers,
        ]);


    }

















    public function CancelBooking($id)
    {

    

        $cancelBooking = $this->bookingService->cancelBooking($id);
        
        $unavailability = $this->unavailabilityService->deleteUnavailabilityByBookingID($id);

        return response()->json([
            'cancelBooking' => $cancelBooking,
        ]);

    }

}
