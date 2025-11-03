<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended($this->redirectPath().'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended($this->redirectPath().'?verified=1');
    }

    /**
     * Determine the redirect path based on user role.
     */
    protected function redirectPath(): string
    {
        $user = auth()->user();

        return match ($user->role) {
            'user' => route('user.dashboard', absolute: false),
            default => '/', // fallback
        };
    }
}
