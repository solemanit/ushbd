@extends('admin.layouts.master')

@section('title', isset($page) ? 'Edit Page | Admin' : 'Add New Page | Admin')

@section('content')
<div class="mt-5 container-xl">
    <div class="card">
        <div class="card-header">
            <h3>{{ isset($page) ? 'Edit Page' : 'Add New Page' }}</h3>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ isset($page) ? route('admin.pages.update', $page->id) : route('admin.pages.store') }}">
                @csrf
                @if(isset($page))
                    @method('PUT')
                @endif

                <div class="mt-3">
                    <label for="title" class="form-label">Page Title:</label>
                    <input type="text" id="title" name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $page->title ?? '') }}"
                        placeholder="Enter page title">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-3">
                    <label for="editor" class="form-label">Page Content:</label>
                    <textarea id="editor" name="content" rows="8"
                        class="form-control @error('content') is-invalid @enderror"
                        placeholder="Write page details...">{{ old('content', $page->content ?? '') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-3 form-check">
                    <input type="checkbox" id="menu_visible" name="menu_visible" value="1" class="form-check-input"
                        {{ old('menu_visible', $page->menu_visible ?? true) ? 'checked' : '' }}>
                    <label for="menu_visible" class="form-check-label">Show this page in website menu</label>
                </div>

                <button type="submit" class="mt-3 btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icon-tabler-check">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l5 5l10 -10" />
                    </svg>
                    {{ isset($page) ? 'Update Page' : 'Create Page' }}
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
