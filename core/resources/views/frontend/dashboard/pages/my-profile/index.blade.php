@extends('frontend.dashboard.layouts.master')

@section('title', 'UpSkill Academia')

@section('content')
    <div class="container-fluid">
        <div class="row">
            {{-- Sidebar --}}
            @include('frontend.dashboard.layouts.partials.sidebar')

            <!-- Main Content -->
            <div class="px-4 py-4 dash-course col-md-12 col-sm-12 col-xl-10">
                <div class="row">
                    <div class="col-12">
                        <!-- Card -->
                        <!-- Card header -->
                        <div class="p-4 mb-4 text-white welcome-section bg-primary rounded-3">
                            <h3 class="mb-0 text-white">Profile Details</h3>
                            <p class="mb-0 text-white">You have full control to manage your account settings.</p>
                        </div>

                        <div class="border-0 shadow-sm card">

                            <!-- Card body -->
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <form action="{{ route('student.profile.update') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-4 d-lg-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            {{-- Profile Photo --}}
                                            <div class="mb-4 text-center">
                                                @if ($user->photo)
                                                    <img src="{{ asset('storage/' . $user->photo) }}"
                                                        class="mb-2 border shadow-sm rounded-circle"
                                                        style="width: 100px; height: 100px; object-fit: cover;"
                                                        alt="Profile Photo">
                                                @else
                                                    <div class="mx-auto mb-2 text-white shadow-sm rounded-circle bg-primary d-flex align-items-center justify-content-center fw-bold"
                                                        style="width: 100px; height: 100px; font-size: 36px;">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                @endif

                                                <div class="w-100 d-flex justify-content-center">
                                                    <label for="photo" class="btn btn-outline-secondary btn-sm me-2">
                                                        Choose Photo
                                                    </label>
                                                    <input type="file" id="photo" name="photo"
                                                        class="d-none @error('photo') is-invalid @enderror"
                                                        accept="image/*">
                                                </div>

                                                @error('photo')
                                                    <div class="mt-1 text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>


                                            <div class="ms-3">
                                                <h5 class="mb-0">Your Avatar</h5>
                                                <p class="mb-0">PNG or JPG no bigger than 800px wide and tall.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-4">

                                    <h4 class="mb-3">Personal Details</h4>
                                    <div class="row gx-3">
                                        <!-- Name -->
                                        <div class="mb-3 col-md-6">
                                            <label for="name" class="form-label">Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name"
                                                value="{{ old('name', $user->name) }}"
                                                class="form-control @error('name') is-invalid @enderror" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Email -->
                                        <div class="mb-3 col-md-6">
                                            <label for="email" class="form-label">Email <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" name="email" id="email"
                                                value="{{ old('email', $user->email) }}"
                                                class="form-control @error('email') is-invalid @enderror" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Profession -->
                                        <div class="mb-3 col-md-6">
                                            <label for="profession" class="form-label">Profession</label>
                                            <input type="text" name="profession" id="profession"
                                                value="{{ old('profession', $user->profession) }}"
                                                class="form-control @error('profession') is-invalid @enderror">
                                            @error('profession')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Gender -->
                                        <div class="mb-3 col-md-6">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select name="gender" id="gender"
                                                class="form-select @error('gender') is-invalid @enderror">
                                                <option value="">Select Gender</option>
                                                <option value="male"
                                                    {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male
                                                </option>
                                                <option value="female"
                                                    {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female
                                                </option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Bio -->
                                        <div class="mb-3 col-12">
                                            <label for="bio" class="form-label">Bio</label>
                                            <textarea name="bio" id="bio" rows="3" class="form-control @error('bio') is-invalid @enderror">{{ old('bio', $user->bio) }}</textarea>
                                            @error('bio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <h4 class="mb-3">Change Password</h4>
                                    <div class="row gx-3">
                                        <!-- Current Password -->
                                        <div class="mb-3 col-md-4">
                                            <label for="current_password" class="form-label">Current Password</label>
                                            <input type="password" name="current_password" id="current_password"
                                                class="form-control @error('current_password') is-invalid @enderror"
                                                placeholder="Leave blank to keep current password">
                                            @error('current_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- New Password -->
                                        <div class="mb-3 col-md-4">
                                            <label for="new_password" class="form-label">New Password</label>
                                            <input type="password" name="new_password" id="new_password"
                                                class="form-control @error('new_password') is-invalid @enderror"
                                                placeholder="Min. 8 characters">
                                            @error('new_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Confirm Password -->
                                        <div class="mb-3 col-md-4">
                                            <label for="new_password_confirmation" class="form-label">Confirm
                                                Password</label>
                                            <input type="password" name="new_password_confirmation"
                                                id="new_password_confirmation" class="form-control"
                                                placeholder="Re-type password">
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary">Update Profile</button>
                                    </div>
                                </form>

                            </div> <!-- End card-body -->
                        </div> <!-- End card -->
                    </div> <!-- End col-12 -->
                </div> <!-- End row -->
            </div> <!-- End Main Content -->
        </div>
    </div>
@endsection
