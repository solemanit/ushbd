@extends('admin.layouts.master')

@section('title', 'Orders | Admin Panel')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <!-- Optional: Add new order button if needed -->
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
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
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
                                    <h3 class="mb-0 card-title fw-bold">Orders</h3>
                                    <p class="m-0 text-secondary">All placed orders</p>
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
                                            <th>#</th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between w-100"
                                                    data-sort="sort-name">Customer Name</button>
                                            </th>
                                            <th>Phone</th>
                                            <th>Product</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between w-100"
                                                    data-sort="sort-date">Ordered Date</button>
                                            </th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody class="table-tbody list">
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td class="sort-name">{{ $order->full_name }}</td>
                                                <td>{{ $order->phone }}</td>
                                                <td>{{ $order->product->name ?? 'N/A' }}</td>
                                                <td>৳{{ $order->total }}</td>
                                                <td>{{ ucfirst($order->status) }}</td>
                                                <td class="sort-date">{{ $order->created_at->format('Y-m-d') }}</td>
                                                <td>
                                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                                        class="btn btn-sm btn-primary">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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

                <script>
                    const advancedTable = {
                        headers: [
                            {"data-sort": "sort-name", name: "Customer Name"},
                            {"data-sort": "sort-date", name: "Ordered Date"}
                        ]
                    };

                    const setPageListItems = (e) => {
                        const perPage = parseInt(e.target.dataset.value);
                        const list = window.tabler_list["advanced-table"];
                        list.page = perPage;
                        list.update();
                        document.querySelector("#page-count").textContent = e.target.dataset.value;
                    };

                    window.tabler_list = window.tabler_list || {};

                    document.addEventListener("DOMContentLoaded", function() {
                        const list = (window.tabler_list["advanced-table"] = new List("advanced-table", {
                            sortClass: "table-sort",
                            listClass: "table-tbody",
                            page: 10,
                            pagination: true,
                            valueNames: advancedTable.headers.map((header) => header["data-sort"])
                        }));

                        const searchInput = document.querySelector("#advanced-table-search");
                        if (searchInput) {
                            searchInput.addEventListener("input", () => {
                                list.search(searchInput.value);
                            });
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>
@endsection
