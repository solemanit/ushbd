@extends('frontend.layouts.master')

@section('title', 'Reset Password')

@section('content')
<section class="py-3 py-md-5 py-xl-8" style="margin-top: 5rem;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                <div class="border card border-light-subtle rounded-4">
                    <div class="p-3 card-body p-md-4 p-xl-4">
                        <div class="mt-2 mb-4">
                            <h3 class="m-0 text-center text-secondary fw-bold flex-grow-1">Set your <span class="text-primary">Password</span></h3>
                        </div>
                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf

                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <!-- Email -->
                            <div class="mb-3 form-floating">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="name@example.com"
                                    value="{{ old('email', $request->email) }}" required autofocus
                                    autocomplete="username">
                                <label for="email">Email</label>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3 form-floating">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="********" required
                                    autocomplete="new-password">
                                <label for="password">New Password</label>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4 form-floating">
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="password_confirmation" name="password_confirmation" placeholder="********"
                                    required autocomplete="new-password">
                                <label for="password_confirmation">Confirm Password</label>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
