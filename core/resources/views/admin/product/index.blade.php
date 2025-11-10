@extends('admin.layouts.master')

@section('title', 'Products | USHBD')

@section('content')
<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-5 d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        Add Product
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <div class="alert-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="icon alert-icon icon-2">
                        <path d="M5 12l5 5l10 -10"></path>
                    </svg>
                </div>
                {{ session('success') }}
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-table">
                        <div class="card-header">
                            <div class="w-full row">
                                <div class="col">
                                    <h3 class="mb-0 card-title fw-bold">Products</h3>
                                    <p class="m-0 text-secondary">All uploaded products</p>
                                </div>
                                <div class="col-md-auto col-sm-12">
                                    <div class="flex-wrap ms-auto d-flex btn-list">
                                        <div class="w-auto input-group input-group-flat">
                                            <span class="input-group-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round"
                                                     stroke-linejoin="round" class="icon icon-1">
                                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                    <path d="M21 21l-6 -6"></path>
                                                </svg>
                                            </span>
                                            <input id="advanced-table-search" type="text"
                                                   class="form-control" placeholder="Search..." autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="advanced-table">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-selectable">
                                    <thead>
                                        <tr>
                                            <th><button class="table-sort d-flex justify-content-between w-100" data-sort="sort-name">Name</button></th>
                                            <th>Brand</th>
                                            <th>Service</th>
                                            <th>Division</th>
                                            <th>District</th>
                                            <th>Image</th>
                                            <th><button class="table-sort d-flex justify-content-between w-100" data-sort="sort-date">Created Date</button></th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody class="table-tbody list">
                                        @foreach ($products as $product)
                                            <tr data-division-id="{{ $product->division_id }}" data-district-id="{{ $product->district_id }}">
                                                <td class="sort-name">{{ $product->name }}</td>
                                                <td>{{ $product->brand->name ?? '-' }}</td>
                                                <td>{{ $product->service->title ?? '-' }}</td>
                                                <td class="division-name">Loading...</td>
                                                <td class="district-name">Loading...</td>
                                                <td>
                                                    @if($product->image)
                                                        <img src="{{ asset('storage/' . $product->image) }}"
                                                             alt="{{ $product->name }}"
                                                             class="rounded img-thumbnail"
                                                             style="max-width: 100px;">
                                                    @else
                                                        <span class="text-muted">No Image</span>
                                                    @endif
                                                </td>
                                                <td class="sort-date">{{ $product->created_at->format('Y-m-d') }}</td>
                                                <td>
                                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    |
                                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal" data-url="{{ route('admin.products.destroy', $product->id) }}">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Delete Modal -->
                                <div class="modal modal-blur fade" id="deleteModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-status bg-danger"></div>
                                            <form id="deleteForm" method="POST" action="">
                                                @csrf
                                                @method('DELETE')
                                                <div class="py-4 text-center modal-body">
                                                    <h5 class="modal-title">Are you sure?</h5>
                                                    <p>Do you really want to delete this product?<br> This action cannot be undone.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer d-flex align-items-center">
                                <div class="dropdown">
                                    <a class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span id="page-count" class="me-1">10</span> <span>records</span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" onclick="setPageListItems(event)" data-value="10">10 records</a>
                                        <a class="dropdown-item" onclick="setPageListItems(event)" data-value="20">20 records</a>
                                        <a class="dropdown-item" onclick="setPageListItems(event)" data-value="50">50 records</a>
                                        <a class="dropdown-item" onclick="setPageListItems(event)" data-value="100">100 records</a>
                                    </div>
                                </div>
                                <ul class="m-0 pagination ms-auto"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('scripts')
<script>
const API_BASE = '{{ rtrim(env("APP_URL"), "/") }}/api';

let divisions = {};
let districts = {};

async function loadDivisions() {
    try {
        const res = await axios.get(`${API_BASE}/divisions`);
        if (res.data.success) {
            res.data.data.forEach(d => divisions[d.id] = d.name);
        }
    } catch (err) {
        console.error('Failed to load divisions:', err);
    }
}

async function loadDistricts() {
    try {
        const res = await axios.get(`${API_BASE}/districts`);
        if (res.data.success) {
            res.data.data.forEach(d => districts[d.id] = d.name);
        }
    } catch (err) {
        console.error('Failed to load districts:', err);
    }
}

document.addEventListener('DOMContentLoaded', async () => {
    await Promise.all([loadDivisions(), loadDistricts()]);

    // Populate table
    document.querySelectorAll('tbody tr[data-division-id]').forEach(row => {
        const divisionId = row.getAttribute('data-division-id');
        const districtId = row.getAttribute('data-district-id');

        row.querySelector('.division-name').textContent = divisions[divisionId] ?? '-';
        row.querySelector('.district-name').textContent = districts[districtId] ?? '-';
    });
});
</script>
@endpush
