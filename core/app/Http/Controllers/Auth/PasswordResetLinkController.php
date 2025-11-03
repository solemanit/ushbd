<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Try to send reset link, regardless of whether user exists
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // === Handle AJAX Response ===
        if ($request->ajax()) {
            if ($status === Password::RESET_LINK_SENT) {
                return response()->json(['message' => 'We’ve Sent You a Reset Link']);
            }

            // Don't show error if user not found
            if ($status === Password::INVALID_USER) {
                return response()->json(['message' => 'This email is incorrect. Please check again.'], 404);
            }

            return response()->json(['message' => __($status)], 422);
        }

        // === Handle Web (non-AJAX) Fallback ===
        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

}
