<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use App\Mail\CustomResetPasswordMailable; // Import your custom mailable
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PasswordResetLinkController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        // Check if the user exists
        $user = DB::table('users')->where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['status' => 'User does not exist'], 404);
        }

        // Generate a new token
        $token = Str::random(64);

        // Store the token in the password_reset_tokens table (or password_resets in older versions)
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => now(),
            ]
        );

        // Send the email with the token using your custom email class
        Mail::to($request->email)->send(new CustomResetPasswordMailable($token, $request->email));

        return response()->json(['status' => 'Email has been sent']);
    }
}
