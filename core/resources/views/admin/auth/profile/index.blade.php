@extends('admin.layouts.master')

@section('title', 'Admin Users | USHBD')

@section('content')
    <div class="page-header d-print-none" aria-label="Page header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.profile.create') }}" class="btn btn-primary btn-5 d-sm-inline-block"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg> Add User</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert"><div class="alert-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon icon-2"><path d="M5 12l5 5l10 -10"></path></svg></div>{{ session('success') }}<a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a></div>
            @endif
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-table">
                            <div class="card-header">
                                <div class="w-full row">
                                    <div class="col">
                                        <h3 class="mb-0 card-title fw-bold">Admin Users</h3>
                                        <p class="m-0 text-secondary">All Data</p>
                                    </div>
                                    <div class="col-md-auto col-sm-12">
                                        <div class="flex-wrap ms-auto d-flex btn-list">
                                            <div class="w-auto input-group input-group-flat">
                                                <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path d="M21 21l-6 -6"></path></svg></span>
                                                <input id="advanced-table-search" type="text" class="form-control" placeholder="Search..." autocomplete="off">
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
                                                <th>
                                                    <button class="table-sort d-flex justify-content-between w-100" data-sort="sort-name">User Name</button>
                                                </th>
                                                <th>
                                                    <button class="table-sort d-flex justify-content-between w-100" data-sort="sort-role">Role</button>
                                                </th>
                                                <th>
                                                    <button class="table-sort d-flex justify-content-between w-100" data-sort="sort-email">Email</button>
                                                </th>
                                                <th>
                                                    <button class="table-sort d-flex justify-content-between w-100" data-sort="sort-status">Status</button>
                                                </th>
                                                <th>
                                                    <button class="table-sort d-flex justify-content-between w-100" data-sort="sort-date">Created Date</button>
                                                </th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody class="table-tbody list">
                                            @foreach ($admins as $admin)
                                                @if(auth('admin')->user()->role === 'admin' || $admin->role !== 'admin')
                                                    <tr>
                                                        <td class="sort-name">{{ $admin->name }}</td>
                                                        <td class="sort-role">{{ $admin->role }}</td>
                                                        <td class="sort-role">{{ $admin->email }}</td>
                                                        <td class="sort-role">@if ($admin->status)<span class="badge bg-green-lt">Active</span>@else<span class="badge bg-red-lt">Inactive</span>@endif</td>

                                                        <td class="sort-date">{{ $admin->created_at->format('Y-m-d') }}</td>
                                                        <td>
                                                            <a href="{{ route('admin.profile.edit', $admin->id) }}" class="btn btn-sm btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg> Edit</a> |
                                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-url="{{ route('admin.profile.destroy', $admin->id) }}"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7h16" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /><path d="M10 12l4 4m0 -4l-4 4" /></svg>Delete</button>
                                                        </td>
                                                    </tr>
                                                @endif
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-2 icon text-danger icon-lg"><path d="M12 9v4"></path><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z"></path><path d="M12 16h.01"></path></svg>
                                                        <h5 class="modal-title">Are you sure?</h5>
                                                        <p>Do you really want to remove file?<br>What you've done cannot be undone.</p>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            var deleteModal = document.getElementById('deleteModal');
                                            deleteModal.addEventListener('show.bs.modal', function(event) {
                                                var button = event.relatedTarget;
                                                var url = button.getAttribute('data-url');
                                                var form = deleteModal.querySelector('#deleteForm');
                                                form.action = url;
                                            });
                                        });
                                    </script>
                                </div>

                                <div class="card-footer d-flex align-items-center">
                                    <div class="dropdown">
                                        <a class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span id="page-count" class="me-1">10</span> <span>records</span>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" onclick="setPageListItems(event)" data-value="10">10
                                                records</a>
                                            <a class="dropdown-item" onclick="setPageListItems(event)" data-value="20">20
                                                records</a>
                                            <a class="dropdown-item" onclick="setPageListItems(event)" data-value="50">50
                                                records</a>
                                            <a class="dropdown-item" onclick="setPageListItems(event)"
                                                data-value="100">100 records</a>
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
                                {
                                    "data-sort": "sort-name",
                                    name: "User Name"
                                },
                                {
                                    "data-sort": "sort-role",
                                    name: "Role"
                                },
                                {
                                    "data-sort": "sort-date",
                                    name: "Created Date"
                                },
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
