<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class CustomVerifyEmailMailable extends Mailable
{
    public $verificationUrl;

    public function __construct($user)
    {
        // Generate a custom verification URL with a 60-minute expiration time
        $this->verificationUrl = URL::temporarySignedRoute(
            'verification.verify', 
            Carbon::now()->addMinutes(60), 
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );
    }

    public function build()
    {
        return $this->subject('Verify Your Email Address')
            ->html('
                <html>
                    <body>
                        <h1>Email Verification</h1>
                        <p>Please verify your email address by clicking the button below:</p>
                        <a href="' . $this->verificationUrl . '">Verify Email</a>
                    </body>
                </html>
            ');
    }
}
