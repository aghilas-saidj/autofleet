<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use App\Models\Unavailability;
use App\Mail\PaymentSuccessMail;
use Illuminate\Support\Facades\Mail;


class ProcessPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    protected $amount;
    protected $currency;
    protected $paymentMethodId;
    protected $uuid;
    protected $unavailabilityID;


    /**
     * Create a new job instance.
     */
    public function __construct($payment_data)
    {
        
        $this-> amount = $payment_data['amount'];
        $this-> currency = $payment_data['currency'];
        $this-> paymentMethodId = $payment_data['paymentMethodId'];
        $this-> uuid = $payment_data['uuid'];
        $this-> unavailabilityID = $payment_data['unavailabilityID'];

    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Set your Stripe API key
        //Stripe::setApiKey(env('STRIPE_SECRET'));
        
        Stripe::setApiKey(config('services.stripe.secret'));

        
        try {

            // Step 1: Verify Payment Record
            $payment = Payment::where('uuid', $this->uuid)->firstOrFail();




            if ($payment->status !== 'pending') {
                return response()->json([
                    'message' => 'Payment cannot be processed. Payment current status is: ' . $payment->status,
                ], 400);
            }


            
            // Step 2: Verify Booking Record
            $booking = Booking::where('id', $payment->booking_id)->firstOrFail();



            if ($booking->status !== 'pending') {
                return response()->json([
                    'message' => 'Payment cannot be processed. Booking current status is: ' . $payment->status,
                ], 400);
            }






            // Step 3:Create a PaymentIntent with Stripe
                    // Create a PaymentIntent with the specified amount and currency

            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $this-> amount*100, // Amount in cents
                'currency' => $this-> currency , // Currency specified in the request
                'payment_method' => $this-> paymentMethodId, // Pass the payment method ID from the request pm_card_amex
                'confirm' => true, // Automatically confirm the payment intent
                'return_url' => 'http://127.0.0.1:8000/api/cars'
            ]);
            // Payment was successful
            // Check Payment Status










            if ($paymentIntent->status === 'succeeded') {
                // Payment succeeded
                //Trigger an event to update the user UI


                            try {
                                // Retrieve and update the payment record
                                $payment = Payment::where('uuid', $this->uuid)->firstOrFail();
                                $payment->status = 'completed';
                             //   $payment->transaction_id = $paymentIntent->id; // Store the Stripe PaymentIntent ID
                                $payment->save();



                            } catch (\Exception $e) {
                                info('Error updating payment record: ' . $e->getMessage());
                                //Notify the admin (payment succeeded but the database has not been updated)
                                //send the payment information to an event to take actions
                            }


                            
                            try {
                                // Retrieve and update the booking record
                                $booking = Booking::where('id', $payment->booking_id)->firstOrFail();
                                $booking->status = 'confirmed';
                                $booking->save();



                            } catch (\Exception $e) {
                                info('Error updating booking record: ' . $e->getMessage());
                                //Notify the admin (payment succeeded but the database has not been updated)
                                //send the booking information to an event to take actions
                            }



                return response()->json([
                    'message' => 'Payment succeeded',
                    'payment_intent_id' => $paymentIntent->id,
                    'payment_intent_client_secret' => $paymentIntent->client_secret,

                ]);








            } elseif ($paymentIntent->status === 'requires_action') {
                // Payment requires additional action (e.g., 3D Secure)
                return response()->json([
                    'message' => 'Payment requires additional action',
                    'payment_intent_client_secret' => $paymentIntent->client_secret,
                ]);





            } else {
                // Payment failed or requires a new payment method
                return response()->json([
                    'message' => 'Payment failed',
                    'status' => $paymentIntent->status,
                ], 400);


            }























            
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle any errors from Stripe, such as insufficient funds or declined card
            \Log::error('Payment processing failed: ' . $e->getMessage());

            $payment = Payment::where('uuid', $this-> uuid)->firstOrFail();
            $payment->status = 'failed';
            $payment->save();

            $booking = Booking::where('id', $payment->booking_id)->firstOrFail();
            $booking->status = 'failed';
            $booking->save();


            $unavailability = Unavailability::where('id', $this-> unavailabilityID)
                    ->first();

                    //this needs to be handled with try catch
                if ($unavailability) {
                    $unavailability->delete();
                } else {
                    // Handle the case where no matching record exists
                    throw new Exception("No matching unavailability record found.");
                }
        }
    }
}