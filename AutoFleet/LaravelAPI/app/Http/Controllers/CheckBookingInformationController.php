<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\infoConfirmationBeforeBookingService;


class CheckBookingInformationController extends Controller
{

    protected $infoconfirmationbeforebookingservice;

    public function __construct(infoConfirmationBeforeBookingService $infoconfirmationbeforebookingservice)  
    {
        $this -> infoconfirmationbeforebookingservice = $infoconfirmationbeforebookingservice;
    }  






    

    public function Confirm(Request $request)
    {

        $validatedData = $request->validate([
            'car_id' => 'required|integer|exists:cars,id',
            'from' => 'required|date|after_or_equal:today',
            'to' => 'required|date|after:from',
            'pickup' => 'required|string|max:255',
            'dropoff' => 'required|string|max:255',
            'totalPrice' => 'required|numeric|min:0',
        ]);





        $response = $this->infoconfirmationbeforebookingservice->Confirm(
            $validatedData['car_id'],
            $validatedData['from'],
            $validatedData['to'],
            $validatedData['pickup'],
            $validatedData['dropoff'],
            $validatedData['totalPrice']
        );



        return $response;


        
    }



}
