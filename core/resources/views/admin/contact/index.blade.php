@extends('admin.layouts.master')

@section('title', 'Contact Info')

@section('content')
<div class="mt-5 container-xl">

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Contact Information</h3>

            @if(!$contactUs)
                <a href="{{ route('admin.contact.create') }}" class="btn btn-primary">
                    Add Contact Info
                </a>
            @endif
        </div>

        <div class="card-body">

            @if($contactUs)
                <form method="POST" action="{{ route('admin.contact.update', $contactUs->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mt-3">
                        <label class="form-label">Address:</label>
                        <input type="text" name="address" class="form-control"
                               value="{{ old('address', $contactUs->address) }}">
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Phone:</label>
                        <input type="text" name="phone" class="form-control"
                               value="{{ old('phone', $contactUs->phone) }}">
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Email:</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email', $contactUs->email) }}">
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Working Days:</label>
                        <input type="text" name="working_days" class="form-control"
                               value="{{ old('working_days', $contactUs->working_days) }}">
                    </div>

                    <button type="submit" class="mt-4 btn btn-success">
                        Update Contact Info
                    </button>

                </form>
            @else
                <p class="text-muted">No contact information added yet.</p>
            @endif

        </div>
    </div>

</div>
@endsection
