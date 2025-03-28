<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $phone;
    public $message;

    public function __construct($name, $email, $phone, $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->message = $message;
    }

    public function build()
    {
        return $this->subject("New Contact Message")
        ->html("
            <h2>New Contact Message</h2>
            <p><strong>Name:</strong> {$this->name}</p>
            <p><strong>Email:</strong> {$this->email}</p>
            <p><strong>Phone:</strong> {$this->phone}</p>
            <p><strong>Message:</strong> {$this->message}</p>
        ");
    }
}
