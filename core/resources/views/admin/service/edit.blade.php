@extends('admin.layouts.master')

@section('title', 'Edit Service | USHBD')

@section('content')
<div class="mt-5 container-xl">
    <div class="card">
        <div class="card-header">
            <h3>Edit Service</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.services.update', $service->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mt-3">
                    <label for="title" class="form-label">Service Title:</label>
                    <input type="text" id="title" name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $service->title) }}"
                        placeholder="Enter service title">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-3">
                    <label for="image" class="form-label">Service Image:</label>
                    <input type="file" id="image" name="image"
                        class="form-control @error('image') is-invalid @enderror">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if($service->image)
                        <div class="mt-3">
                            <p class="mb-1 fw-semibold">Current Image:</p>
                            <img src="{{ asset('storage/' . $service->image) }}"
                                 alt="Current Service Image"
                                 class="rounded img-thumbnail"
                                 style="max-width: 300px;">
                        </div>
                    @endif
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
                    Update Service
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
