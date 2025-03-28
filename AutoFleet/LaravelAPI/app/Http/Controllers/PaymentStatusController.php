<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Booking;

class PaymentStatusController extends Controller
{
	public function getstatus(Request $request)
    {
        // $request->validate([
        //     'payment_method' => 'required|string',
        // ]);


        try {
            $payment = Payment::where('payment_method', $request->payment_method)->firstOrFail();
            $booking = Booking::where('id', $payment->booking_id)->firstOrFail();
         //   return $payment;
             return response()->json([
                 'paymentInfo' => $payment,
                 'bookingInfo' => $booking,
             ]);


            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Payment method not found.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred.',
            ], 500);
        }
    }
}
