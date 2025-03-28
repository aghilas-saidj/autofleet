<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookingService
{

    public function createBooking(array $data)
    {

        $booking = Booking::create($data);
        return $booking;

    }




    public function updateBooking($id, array $data)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            throw new ModelNotFoundException('Booking not found');
        }

        $booking->update($data);
        return $booking;
    }







    public function deleteBooking($id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            throw new ModelNotFoundException('Booking not found');
        }

        return $booking->delete();
    }




    public function getAllBookings()
    {
        return Booking::all();
    }














    public function getBookingById($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            throw new ModelNotFoundException('Booking not found');
        }

        return $booking;
    }







    public function getBookingsByCar($car_id)
    {
        return Booking::where('car_id', $car_id)->get();
    }








    public function getBookingsByUser($user_id)
    {
        return Booking::where('user_id', $user_id)->get();
    }







    public function getBookingsByStatus($status)
    {
        return Booking::where('status', $status)->get();
    }










    public function getBookingsByDateRange($start_date, $end_date)
    {
        return Booking::whereBetween('start_date', [$start_date, $end_date])->get();
    }










    public function getBookingByReferenceCode($reference_code)
    {
        $booking = Booking::where('reference_code', $reference_code)->first();

        if (!$booking) {
            throw new ModelNotFoundException('Booking with the reference code not found');
        }

        return $booking;
    }












    public function NewCustomers()
    {
        // Get all bookings where the start date is today or in the future
        $bookings = Booking::where('start_date', '>=', now())->get(); 
        return response()->json($bookings); // Convert to JSON response
    }










    public function countNewCustomers()
    {
        // Count the unique customer IDs for bookings starting today or in the future
        $uniqueCustomerCount = Booking::where('start_date', '>=', now())
                                     //  ->distinct('email_address') // Ensure 'customer_id' is unique
                                       ->count('email_address');   // Count the unique customer IDs
    
        return response()->json($uniqueCustomerCount);
    }





    




    public function OngoingCustomers()
    {
        // Get all bookings where the start date is today or in the future
        $bookings = Booking::where('start_date', '<=', now())
        ->where('end_date', '>=', now())
        ->get(); 
        return response()->json($bookings); // Convert to JSON response
    }











    public function countOngoingCustomers()
    {
        // Get all bookings where the start date is today or in the future
        $bookings = Booking::where('start_date', '<=', now())
        ->where('end_date', '>=', now())
     //   ->distinct('email_address') // Ensure 'customer_id' is unique
        ->count('email_address');   // Count the unique customer IDs

        return response()->json($bookings+1); // Convert to JSON response
    }














    public function countAllCustomers()
{
    // Count the distinct email addresses from all bookings
    $emailCount = Booking::all()
                       //  ->unique('email_address')
                         ->count();

    return response()->json([
        'email_count' => $emailCount // Count of unique emails
    ]);
}













public function countAllBookings()
{
    // Count the distinct email addresses from all bookings
    $bookingCount = Booking::all()
                         ->count();

    return response()->json($bookingCount);
}














public function countOngoingBookings()
{
    // Get all bookings where the start date is today or in the future
    $bookings = Booking::where('start_date', '<=', now())
    ->where('end_date', '>=', now())
    ->count();   // Count the unique customer IDs

    return response()->json($bookings); // Convert to JSON response
}















public function countFutureBookings()
{
    // Count the unique customer IDs for bookings starting today or in the future
    $futureBookingCount = Booking::where('start_date', '>=', now())
                                   ->count(); 

    return response()->json($futureBookingCount);
}


















public function cancelBooking($id)
{
    $booking = Booking::find($id);

    if (!$booking) {
        throw new ModelNotFoundException('Booking not found');
    }

    $data = [
        'status'=>'canceled',
    ];

    $booking->update($data);

    return $booking;
}


}
