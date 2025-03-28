<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class UpdatePasswordController extends Controller
{
    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    
        // Find the user by email
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json(['status' => 'User not found.'], 404);
        }
    
        // Update the user's password
        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60), // Optional: Update remember token
        ])->save();
    
        return response()->json(['status' => 'Password has been successfully reset.']);
    }


}