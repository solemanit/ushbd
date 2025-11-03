@extends('admin.layouts.master')

@section('title', 'Edit Contact Info')

@section('content')
<div class="mt-5 container-xl">
    <div class="card">
        <div class="card-header">
            <h3>Edit Contact Information</h3>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.contact.update', $contactUs->id) }}">
                @csrf
                @method('PUT')

                <div class="mt-3">
                    <label for="address" class="form-label">Address:</label>
                    <input type="text" id="address" name="address"
                        class="form-control @error('address') is-invalid @enderror"
                        value="{{ old('address', $contactUs->address) }}"
                        placeholder="Enter address">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-3">
                    <label for="phone" class="form-label">Phone:</label>
                    <input type="text" id="phone" name="phone"
                        class="form-control @error('phone') is-invalid @enderror"
                        value="{{ old('phone', $contactUs->phone) }}"
                        placeholder="Enter phone number">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $contactUs->email) }}"
                        placeholder="Enter email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-3">
                    <label for="working_days" class="form-label">Working Days:</label>
                    <input type="text" id="working_days" name="working_days"
                        class="form-control @error('working_days') is-invalid @enderror"
                        value="{{ old('working_days', $contactUs->working_days) }}"
                        placeholder="Example: Sat - Thu, 9AM to 6PM">
                    @error('working_days')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="mt-4 btn btn-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icon-tabler-device-floppy">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M6 4h10l4 4v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-16a2 2 0 0 1 2 -2z" />
                        <circle cx="12" cy="14" r="2" />
                        <path d="M14 4v4h-8v-4z" />
                    </svg>
                    Update Contact Info
                </button>

            </form>
        </div>
    </div>
</div>
@endsection
