@extends('admin.layouts.master')

@section('title', 'Add New User | USHBD')

@section('content')
<div class="mt-5 container-xl">
    <div class="card">
        <div class="card-header"><h3>Add New User</h3></div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.profile.store') }}">
                @csrf

                <div class="mt-3">
                    <label for="name" class="form-label">Username:</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $admin->name ?? '') }}" placeholder="Enter your user name">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mt-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $admin->email ?? '') }}" placeholder="Enter your email">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>


                    <div class="col-md-6">
                        <label for="role" class="form-label">Role:</label>
                        <select name="role" id="role" class="form-select @error('role') is-invalid @enderror">
                            <option value="">Select</option>
                            @if(auth('admin')->user()->role === 'admin')
                            <option value="admin">Admin</option>
                            @endif
                            <option value="manager">Manager</option>
                            <option value="editor">Editor</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                <div class="mt-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter password">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mt-3">
                    <label for="password_confirmation" class="form-label">Confirm Password:</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm password">
                    @error('password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>


                <button type="submit" class="mt-3 btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icon-tabler-check">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l5 5l10 -10" />
                    </svg> Create Admin
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
