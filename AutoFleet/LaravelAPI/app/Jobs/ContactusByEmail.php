<?php

namespace App\Jobs;

use App\Mail\ContactUsMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Log;
use Exception;

class ContactusByEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $name;
    protected $email;
    protected $phone;
    protected $message;

    public function __construct($name, $email, $phone, $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->message = $message;
    }

    public function handle()
    {

        try {
            Mail::to('aghilassaidj@gmail.com')->send(new ContactUsMail($this->name, $this->email, $this->phone, $this->message));
            Log::info("ContactUs email sent successfully to admin@example.com");

        } catch (Exception $e) {
            Log::error("Failed to send ContactUs email: " . $e->getMessage());
            throw $e; // Rethrow to let Laravel retry the job if queue is enabled        }
    }
}
}