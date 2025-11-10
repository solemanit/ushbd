@extends('admin.layouts.master')

@section('title', 'Forgot Password | USHBD')

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
                <form method="POST" action="{{ route('admin.password.email') }}">
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
                        <input id="email" class="form-control @error('email') is-invalid @enderror" placeholder="your@email.com" type="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary btn-4 w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
                            <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"></path><path d="M3 7l9 6l9 -6"></path></svg>
                            {{ __('Email Password Reset Link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
