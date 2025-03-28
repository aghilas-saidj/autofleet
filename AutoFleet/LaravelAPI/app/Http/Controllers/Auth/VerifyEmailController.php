<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class VerifyEmailController
{
    public function __invoke(Request $request)
    {
        // Find the user by ID from the URL
        $user = User::find($request->route('id'));

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Check if the hash matches the user's email
        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            return response()->json(['message' => 'Invalid verification link.'], 403);
        }

        // Check if the user has already verified their email
        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.']);
        }

        // Mark the user's email as verified
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json(['message' => 'Email verified successfully.']);
    }
}
