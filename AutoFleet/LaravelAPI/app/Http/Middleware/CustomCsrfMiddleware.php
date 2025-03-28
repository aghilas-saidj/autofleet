<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class CustomCsrfMiddleware extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/*',          // Example: Exclude all API routes
        'webhook/*',      // Example: Exclude webhook URLs
        'payment/notify', // Example: Exclude payment gateway callbacks
    ];
}
