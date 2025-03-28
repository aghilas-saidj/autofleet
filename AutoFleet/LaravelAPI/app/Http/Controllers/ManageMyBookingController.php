<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class ManageMyBookingController extends Controller
{
	public function getmybooking(Request $request)
	{



		$validatedData = $request->validate([
			'email_address' => 'required|email|exists:bookings,email_address',
			'reference_code' => 'required|string|exists:bookings,reference_code',
		]);
	



		$booking = Booking::where("email_address", $validatedData['email_address'])
						  ->where("reference_code", $validatedData['reference_code'])
						  ->get();
	



		if ($booking->isEmpty()) {
			return response()->json(['message' => 'Rental not found'], 404);
		}


		
	
		return response()->json($booking);
	}
}
