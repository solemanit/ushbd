<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        if (session()->has('redirect_after_login')) {
            $redirectUrl = session('redirect_after_login');
            session()->forget('redirect_after_login');

            $request->session()->flash('message', 'Login successful. Please complete your enrollment.');

            if ($request->ajax()) {
                return response()->json(['redirect' => $redirectUrl]);
            }

            return redirect()->to($redirectUrl);
        }

        if ($request->ajax()) {
            $redirectUrl = '';
            if ($request->user()->role == 'user') {
                $redirectUrl = route('user.dashboard');
            } else {
                return response()->json(['error' => 'Role not found'], 403);
            }
            return response()->json(['redirect' => $redirectUrl]);
        }

        abort(404);
    }



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
