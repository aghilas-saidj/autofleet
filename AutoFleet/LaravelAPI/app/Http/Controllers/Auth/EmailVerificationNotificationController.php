<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Mail\CustomVerifyEmailMailable; // Import your custom mailable
use Illuminate\Support\Facades\Mail; // Make sure to import Mail facade


class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['status' => 'Email already verified.'], 200);
        }

        // Send the custom email verification notification
        Mail::to($request->user()->email)->send(new CustomVerifyEmailMailable($request->user()));

        return response()->json(['status' => 'Verification link sent.']);
    }
}
