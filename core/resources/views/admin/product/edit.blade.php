@extends('admin.layouts.master')

@section('title', 'Edit Product')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="mt-5">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="row">
                    @csrf
                    @method('PUT')

                    {{-- Left Sidebar: Post Content --}}
                    <div class="col-md-8">
                        <div class="mb-3 shadow-sm card">
                            <div class="card-header">
                                <h3 class="card-title">Product Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    {{-- Category --}}
                                    <div class="mt-3 col-md-4">
                                        <label for="category_id" class="form-label">Category:</label>
                                        <select name="category_id"
                                            class="form-select @error('category_id') is-invalid @enderror">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Division --}}
                                    <div class="mt-3 col-md-4">
                                        <label for="division_id" class="form-label">Division:</label>
                                        <select id="division_id" name="division_id"
                                            class="form-select @error('division_id') is-invalid @enderror">
                                            <option value="">Loading divisions...</option>
                                        </select>
                                        @error('division_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- District --}}
                                    <div class="mt-3 col-md-4">
                                        <label for="district_id" class="form-label">District:</label>
                                        <select id="district_id" name="district_id"
                                            class="form-select @error('district_id') is-invalid @enderror" {{ $product->district_id ? '' : 'disabled' }}>
                                            <option value="">Select District</option>
                                        </select>
                                        @error('district_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Product Name --}}
                                <div class="mt-3">
                                    <label for="name" class="form-label">Product Name:</label>
                                    <input type="text" id="name" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $product->name) }}" placeholder="Enter product name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Description --}}
                                <div class="mt-3">
                                    <label for="description" class="form-label">Product Description:</label>
                                    <textarea id="editor" name="description" class="form-control @error('description') is-invalid @enderror"
                                        placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    {{-- Price --}}
                                    <div class="mt-3 col-md-6">
                                        <label for="price" class="form-label">Price (BDT):</label>
                                        <input type="number" id="price" name="price"
                                            class="form-control @error('price') is-invalid @enderror"
                                            value="{{ old('price', $product->price) }}" placeholder="Enter product price">
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Discount --}}
                                    <div class="mt-3 col-md-6">
                                        <label for="discount" class="form-label">Discount (BDT):</label>
                                        <input type="number" id="discount" name="discount"
                                            class="form-control @error('discount') is-invalid @enderror"
                                            value="{{ old('discount', $product->discount) }}" placeholder="Enter discount">
                                        @error('discount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Sidebar: Image, Status, Submit --}}
                    <div class="col-md-4">
                        <div class="mb-3 shadow-sm card">
                            <div class="card-header">
                                <h3 class="card-title">Settings</h3>
                            </div>
                            <div class="card-body">

                                {{-- Image Preview --}}
                                <div class="mb-3 text-center">
                                    <label class="form-label d-block">Preview</label>
                                    <img id="imagePreview" src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder-image.webp') }}" alt="Thumbnail"
                                        class="mb-3 rounded img-fluid" style="max-height:200px;">
                                </div>

                                {{-- Upload Thumbnail --}}
                                <div class="mb-3">
                                    <label class="form-label">Upload Thumbnail</label>
                                    <input type="file" name="image"
                                        class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Publish Status --}}
                                <div class="mb-3">
                                    <label class="form-label">Publish Status</label>
                                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                                        <option value="">Select Status</option>
                                        <option value="1" {{ old('status', $product->status) == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $product->status) == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Submit Button --}}
                                <div class="mt-4 text-end">
                                    <button type="submit" class="px-4 btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icon-tabler-check">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l5 5l10 -10" />
                                        </svg>
                                        Update Product
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form> {{-- End form --}}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const API_BASE = '{{ rtrim(env("APP_URL"), "/") }}/api';

    const divisionSelect = document.getElementById('division_id');
    const districtSelect = document.getElementById('district_id');

    const populateSelect = (select, data, placeholder = 'Select option') => {
        select.innerHTML = `<option value="">${placeholder}</option>`;
        data.forEach(item => {
            select.innerHTML +=
                `<option value="${item.id}">${item.name} &nbsp;–&nbsp; ${item.bn_name}</option>`;
        });
        select.disabled = false;
    };

    const resetSelect = (select, placeholder = 'Select option') => {
        select.innerHTML = `<option value="">${placeholder}</option>`;
        select.disabled = true;
    };

    async function loadDivisions(selectedId = null) {
        try {
            const { data } = await axios.get(`${API_BASE}/divisions`);
            if (data.success) populateSelect(divisionSelect, data.data, 'Select Division');
            if (selectedId) divisionSelect.value = selectedId;
        } catch (err) {
            console.error('Error loading divisions:', err);
            divisionSelect.innerHTML = `<option value="">Failed to load divisions</option>`;
        }
    }

    async function loadDistricts(divisionId, selectedId = null) {
        try {
            const { data } = await axios.get(`${API_BASE}/districts/${divisionId}`);
            if (data.success) populateSelect(districtSelect, data.data, 'Select District');
            if (selectedId) districtSelect.value = selectedId;
        } catch (err) {
            console.error('Error loading districts:', err);
        }
    }

    // Event: Division change → load districts
    divisionSelect.addEventListener('change', function() {
        resetSelect(districtSelect, 'Select District');
        if (this.value) loadDistricts(this.value);
    });

    // Load divisions on page load and set selected values
    loadDivisions({{ $product->division_id ?? 'null' }}).then(() => {
        if ({{ $product->division_id ?? 'null' }}) {
            loadDistricts({{ $product->division_id }}, {{ $product->district_id ?? 'null' }});
        }
    });
</script>
@endpush
