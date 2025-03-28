<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class AuthenticatedLoginController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request):JsonResponse
    {
        $request->authenticate();
        $user = $request->user();


        

        // Create a token for the authenticated user
        $token = $user->createToken('CarRentalSoftware')->plainTextToken;

        // Return the token in the response
        return response()->json(['token' => $token , 'id' => $user->id ,'name' => $user->name, 'email' => $user->email , 'role' => $user->role ], 200);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('api')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
