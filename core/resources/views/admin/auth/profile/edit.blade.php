@extends('admin.layouts.master')

@section('title', 'Edit Admin | USHBD')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="mt-5 row row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Admin</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.profile.update', $admin->id) }}" method="POST" class="space-y-3">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" id="name" name="name" placeholder="Enter name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $admin->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="email" id="email" name="email" placeholder="Enter email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $admin->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @if(auth('admin')->user()->role === 'admin')
                                <div class="mt-3 row">
                                    <div class="col-md-6">
                                        <label for="role" class="form-label">Role:</label>
                                        <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                                            <option value="admin" {{ old('role', $admin->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="manager" {{ old('role', $admin->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                                            <option value="editor" {{ old('role', $admin->role) == 'editor' ? 'selected' : '' }}>Editor</option>
                                        </select>
                                        @error('role')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @else
                                <input type="hidden" name="role" value="{{ $admin->role }}">
                            @endif


                            <div class="mt-3 row">
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password:</label>
                                    <input type="password" id="password" name="password" placeholder="Leave blank to keep unchanged"
                                        class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">Confirm Password:</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-label">Status</div>
                                <label class="form-check form-switch form-switch-2">
                                    <input type="hidden" name="status" value="0">
                                    <input class="form-check-input" type="checkbox" name="status" value="1" {{ old('status', $admin->status) ? 'checked' : '' }}>
                                    <span class="form-check-label">Active</span>
                                </label>
                                @error('status') <div class="mt-1 text-danger">{{ $message }}</div> @enderror
                            </div>


                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icon-tabler-check">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 12l5 5l10 -10" />
                                    </svg>
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
