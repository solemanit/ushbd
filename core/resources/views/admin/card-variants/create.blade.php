@extends('admin.layouts.master')

@section('title', 'Create Card Variant | USHBD')

@section('content')
<div class="mt-5 container-xl">
    <div class="card">
        <div class="card-header"><h3>Create Card Variant</h3></div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.card-variants.store') }}">
                @csrf

                <div class="mt-3">
                    <label for="name" class="form-label">Variant Name:</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" placeholder="Enter variant name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                        placeholder="Enter variant description">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="mt-3 btn btn-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icon-tabler-plus">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 5v14m-7-7h14" />
                    </svg> Create Card Variant
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
