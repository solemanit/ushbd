<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:user']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        event(new Registered($user));
        Auth::login($user);

        // Check for redirect_after_login session
        if (session()->has('redirect_after_login')) {
            $redirectUrl = session('redirect_after_login');
            session()->forget('redirect_after_login');

            $request->session()->flash('message', 'Registration successful! Please complete your enrollment now.');

            if ($request->ajax()) {
                return response()->json(['redirect' => $redirectUrl]);
            }

            return redirect()->to($redirectUrl);
        }


        $redirectRoute = match ($user->role) {
            'user' => route('user.dashboard'),
            default => route('user.dashboard'),
        };

        if ($request->ajax()) {
            return response()->json(['redirect' => $redirectRoute]);
        }

        return redirect($redirectRoute);
    }
}
