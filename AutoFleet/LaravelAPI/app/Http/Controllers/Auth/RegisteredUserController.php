<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendWelcomeEmail;
use App\Mail\CustomVerifyEmailMailable;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request):JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role'=>'customer'
        ]);

        $token = $user->createToken('CarRentalSoftware')->plainTextToken;

        Mail::to($user->email)->send(new CustomVerifyEmailMailable($user));

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token
        ], 201); // HTTP status code 201 for created
    }
}
