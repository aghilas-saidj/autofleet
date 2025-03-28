<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = Auth::user(); // Get the authenticated user

        // Check if the user is authenticated and has the "admin" role
        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized - Admins only'], 403);
        }



        return $next($request);
    }
}
