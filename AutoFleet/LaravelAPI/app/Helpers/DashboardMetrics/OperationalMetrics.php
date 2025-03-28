<?php

namespace App\Helpers\DashboardMetrics;

use App\Services\BookingService;

class OperationalMetrics
{
    
    protected $bookingservice;

    public function __construct(BookingService $bookingservice) {
        $this->bookingservice = $bookingservice;
    }


    public function get()
    {


        
        $countAllBookings = $this->bookingservice->countAllBookings();
        $countOngoingBookings = $this->bookingservice->countOngoingBookings();
        $countFutureBookings = $this->bookingservice->countFutureBookings();


        


        return response()->json([
            'count_all_bookings' => $countAllBookings,
            'count_ongoing_bookings' => $countOngoingBookings,
            'count_future_bookings' => $countFutureBookings,
        ]);








    }
}
