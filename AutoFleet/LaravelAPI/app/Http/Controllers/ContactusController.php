<?php

namespace App\Http\Controllers;

use App\Jobs\ContactusByEmail;
use Illuminate\Http\Request;



class ContactusController
{

    public function sendContactEmail(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'message' => 'required|string',
        ]);




    
        ContactusByEmail::dispatch(
            $request->name,
            $request->email,
            $request->phone,
            $request->message
        );
    

        
        return response()->json(['message' => 'Your message has been sent successfully!'], 200);
    }
}
