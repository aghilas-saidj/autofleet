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

class NewPasswordController extends Controller
{
    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $tokenData = \DB::table('password_reset_tokens')->where('email', $request->email)->first();
        if (!$tokenData || $tokenData->token !== $request->token) {
            return response()->json(['status' => 'This password reset token is invalid.'], 400);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['status' => 'User not found.'], 404);
        }

        $user->forceFill([
            'password' => Hash::make($request->password), // Hash the new password
            'remember_token' => Str::random(60), // Optional: Update remember token
        ])->save();


        \DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        return response()->json(['status' => 'Password has been successfully reset.']);


        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
 //       $status = Password::reset(
   //         $request->only('email', 'password', 'password_confirmation', 'token'),
     //       function ($user) use ($request) {
       //         $user->forceFill([
         //           'password' => Hash::make($request->password),
           //         'remember_token' => Str::random(60),
             //   ])->save();
//
  ///              event(new PasswordReset($user));
     //       }
       // );

   //     if ($status != Password::PASSWORD_RESET) {
     //       throw ValidationException::withMessages([
       //         'email' => [__($status)],
         //   ]);
        //}

     //   return response()->json(['status' => __($status)]);
    }
}
