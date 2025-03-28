<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\BookingService;

class ProfileController extends Controller
{

    protected $userService;
    protected $bookingService;


    public function __construct(UserService $userService, BookingService $bookingService)
    {
        $this->userService = $userService;
        $this->bookingService = $bookingService;

    }





    public function getProfile($id) {
        
            try {
                $user = $this->userService->getUserById($id);
                $bookings = $this->bookingService->getBookingsByUser($id);



                $data = [
                    'userInfo'=>$user,
                    'bookings'=>$bookings,
                ];



                return response()->json($data);



                

            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response()->json(['error' => 'User not found'], 404);
            }
        }





    
}