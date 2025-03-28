<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    	
        $user = Auth::user(); // Get the authenticated user

        // Check if the "id" in the URI matches the authenticated user's ID
        if (!$user || $request->route('id') != $user->id) {
            return response()->json(['message' => 'Unauthorized - Not your account'], 403);
        }

        return $next($request);
    }
}
