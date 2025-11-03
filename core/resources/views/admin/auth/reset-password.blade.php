@extends('admin.layouts.master')

@section('title', 'Reset Password | UpSkill Academia')

@section('content')
<div class="page page-center">
    <div class="container py-4 container-tight">
        <div class="mb-4 text-center">
            <a href="#" class="navbar-brand navbar-brand-autodark">
                <img width="150" src="{{ asset('images/ushbd.png') }}" class="logo-img" alt="">
            </a>
        </div>
        <div class="card card-md">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.password.store') }}">
                    @csrf
                    <h2 class="mb-4 text-center card-title">{{ __('Forgot password') }}</h2>
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-4 alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p class="mb-4 text-secondary">{{ __('Enter your email address and your password will be reset and emailed to you.') }}</p>
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email address') }}</label>
                        <input id="email" class="form-control @error('email') is-invalid @enderror" placeholder="your@email.com" type="email" name="email" value="{{ old('email', request()->input('email')) }}" required autocomplete="new-password">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    </div>
                    <div class="mb-2">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <div class="input-group input-group-flat">
                            <input id="password" class="password-field form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="new-password">
                            <span class="input-group-text toggle-password">
                                <a href="#" class="link-secondary" data-bs-toggle="tooltip" aria-label="Show password" data-bs-original-title="Show password">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path></svg>
                                </a>
                            </span>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                        <div class="input-group input-group-flat">
                            <input id="password_confirmation" class="password-field form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" required autocomplete="new-password">
                            <span class="input-group-text toggle-password">
                                <a href="#" class="link-secondary" data-bs-toggle="tooltip" aria-label="Show password" data-bs-original-title="Show password">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path></svg>
                                </a>
                            </span>
                            @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary btn-4 w-100">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
