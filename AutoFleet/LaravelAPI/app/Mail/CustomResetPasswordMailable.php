<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomResetPasswordMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;

    public function __construct(string $token, string $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function build()
    {
        // Generate the password reset URL
        $url = url('api/reset-password?token=' . $this->token . '&email=' . $this->email);

        // Customize your email content here
        $content = "
            <p>Hi,</p>
            <p>To reset your password, please click the link below:</p>
            <p><a href='{$url}'>Reset Password</a></p>
            <p>If you did not request a password reset, please ignore this email.</p>
        ";

        // Customize your email content here
        return $this->subject('Password Reset Request')
                    ->html($content); // Send as HTML
    }
}
