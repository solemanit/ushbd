@extends('admin.layouts.master')

@section('title', 'Add New Banner | UpSkill Academia')

@section('content')
<div class="mt-5 container-xl">
    <div class="card">
        <div class="card-header"><h3>Add New Banner</h3></div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mt-3">
                    <label for="title" class="form-label">Banner Title:</label>
                    <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}" placeholder="Enter banner title">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-3">
                    <label for="banner" class="form-label">Banner Image:</label>
                    <input type="file" id="banner" name="banner" class="form-control @error('banner') is-invalid @enderror">
                    @error('banner')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="mt-3 btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icon-tabler-check">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l5 5l10 -10" />
                    </svg> Create Banner
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
