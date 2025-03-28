<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    public $booking;

    /**
     * Create a new message instance.
     *
     * @param $payment
     * @param $booking
     */
    public function __construct($payment, $booking)
    {
        $this->payment = $payment;
        $this->booking = $booking;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Construct the email content
        $content = "
        <html>
            <body>
                <h1>Payment Successful!</h1>
                <p>Payed amount: " . $this->payment->amount . "</p>

                <p>Start location: " . $this->booking->pickuplocation . "</p>
                <p>End location: " . $this->booking->dropofflocation . "</p>

                <p>Start Date: " . $this->booking->start_date . "</p>
                <p>End Date: " . $this->booking->end_date . "</p>
                <p>Reference code: " . $this->booking->reference_code . "</p>

                <p>Thank you for your booking!</p>
            </body>
        </html>";

        return $this->subject('Payment Success')
                    ->to('jon47jon47@gmail.com') // Set the recipient email
                    ->html($content); // Directly set HTML content
    }
}