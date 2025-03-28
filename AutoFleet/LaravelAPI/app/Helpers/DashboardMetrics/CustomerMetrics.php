<?php

namespace App\Helpers\DashboardMetrics;

use App\Services\BookingService;
//use App\Services\Users;

class CustomerMetrics
{
    
    protected $bookingservice;

    public function __construct(BookingService $bookingservice) {
        $this->bookingservice = $bookingservice;
    }


    public function get()
    {


        
        $newCustomers = $this->bookingservice->NewCustomers();
        $numberOfNewCustomers = $this->bookingservice->countNewCustomers();

        $ongoingCustomers = $this->bookingservice->OngoingCustomers();
        $numberOfOngoingCustomers = $this->bookingservice->countOngoingCustomers();


        $numberOfAllCustomers = $this->bookingservice->countAllCustomers();

        
        


        return response()->json([
            'new_customers' => $newCustomers,
            'number_of_new_customers' => $numberOfNewCustomers,
            'ongoing_customers' => $ongoingCustomers,
            'number_of_ongoing_customers' => $numberOfOngoingCustomers,
            'number_of_all_customers' => $numberOfAllCustomers,

        ]);








    }
}
