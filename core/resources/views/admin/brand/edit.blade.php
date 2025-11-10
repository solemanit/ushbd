@extends('admin.layouts.master')

@section('title', 'Edit Brand | USHBD')

@section('content')
<div class="mt-5 container-xl">
    <div class="card">
        <div class="card-header"><h3>Edit Brand</h3></div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.brands.update', $brand->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mt-3">
                    <label for="name" class="form-label">Brand Name:</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $brand->name) }}" placeholder="Enter brand name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- <div class="mt-3">
                    <label for="logo" class="form-label">Brand Logo:</label>
                    <input type="file" id="logo" name="logo" class="form-control @error('logo') is-invalid @enderror">
                    @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if($brand->logo)
                        <div class="mt-2">
                            <p>Current Logo:</p>
                            <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" style="height: 80px; width: auto; border: 1px solid #ccc; padding: 5px;">
                        </div>
                    @endif
                </div> --}}

                <button type="submit" class="mt-3 btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icon-tabler-check">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l5 5l10 -10" />
                    </svg> Update Brand
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
