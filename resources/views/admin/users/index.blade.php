
@extends('layout.app')
@section('content')
    <style>
        /* Custom CSS */
        .card {
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-bottom: 1px solid #e9ecef;
        }

        .card-title {
            margin-bottom: 0;
            font-size: 1.25rem;
            font-weight: 500;
        }

        .form-select {
            border-radius: 0.25rem;
        }

        .table-responsive {
            padding: 1rem;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .avatar-wrapper {
            display: flex;
            align-items: center;
        }

        .avatar img {
            width: 40px;
            height: 40px;
            object-fit: cover;
        }

        .user-name {
            display: flex;
            align-items: center;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.5em 0.75em;
        }

        .btn-icon {
            padding: 0.5em;
        }

        .dropdown-menu-end {
            right: 0;
            left: auto;
        }

        .pagination {
            margin-bottom: 0;
        }

        .pagination .page-item .page-link {
            border-radius: 0.25rem;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }

        .pagination .page-link {
            color: #007bff;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
            margin-top: 0;
        }

        .dropdown-menu {
            display: none;
        }
    </style>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">



    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card" style="margin-bottom: 20px;">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Users</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h3 class="mb-0 me-2">{{ $users->count() }}</h3>
                                </div>
                                <small>Total Users</small>
                            </div>
                            <span class="badge bg-label-primary rounded p-2">
                                <i class="bx bx-user bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="margin-bottom: 20px;">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Roles</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h3 class="mb-0 me-2">{{ $roles->count() }}</h3>
                                </div>
                                <small>Total Roles</small>
                            </div>
                            <span class="badge bg-label-primary rounded p-2">
                                <i class="bx bx-check-shield bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="margin-bottom: 20px;">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Faculty</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h3 class="mb-0 me-2">{{ $faculties->count() }}</h3>
                                </div>
                                <small>Total Faculty</small>
                            </div>
                            <span class="badge bg-label-primary rounded p-2">
                                <i class="bx bx-buildings bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title">User Management</h5>
            </div>
            <div class="card-datatable table-responsive">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="me-3">
                        <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="form-select"
                            id="itemsPerPage">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="d-flex">
                        <input type="search" class="form-control" id="searchInput" style="width: auto !important"
                            placeholder="Search.." aria-controls="DataTables_Table_0">
                        <a href="{{ route('users.export') }}" class="btn btn-label-secondary mx-3">
                            <i class="bx bx-export me-1"></i>Export
                        </a>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="bx bx-plus me-0 me-sm-1"></i> Add New User
                        </button>
                        @include('admin.users.modals.add_user_modal')
                    </div>
                </div>
                <table id="myTable" class="datatables-users table border-top">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Role</th>
                            <th>Faculty</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="user-name">
                                        <img src="{{ $user->profile_photo_url ?? 'default_profile_photo_url' }}"
                                            alt="user" class="rounded-circle me-2" width="40" height="40">
                                        {{ $user->name }}
                                    </div>
                                </td>
                                <td>{{ Str::ucfirst($user->role ? $user->GotRole->name : 'No Role Assigned') }}</td>
                                <td>
                                    @if ($user->faculty == null)
                                        No Faculty Assigned
                                    @else
                                        {{ $user->HasFaculty->title }}
                                    @endif
                                </td>
                                <td>
                                    @if ($user->user_status == 1)
                                        <span class="badge bg-label-success me-1">Active</span>
                                    @else
                                        <span class="badge bg-label-secondary me-1">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                            <a href="{{ route('admin.users.show', $user->id) }}"
                                                class="dropdown-item">View</a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item"
                                                    onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-between align-items-center" style="margin:1%">
                    <div id="tableInfo">Showing 1 to 10 of 50 entries</div>
                    <nav>
                        <ul class="pagination" id="pagination">
                            <li class="page-item disabled" id="prevPage"><a class="page-link" href="#">Previous</a>
                            </li>
                            <li class="page-item" id="nextPage"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Disable default search and pagination
            let table = new DataTable('#myTable', {
                "paging": false,
                "info": false,
                "searching": false,
                "lengthChange": false
            });

            let itemsPerPage = parseInt(document.getElementById('itemsPerPage').value);
            let totalItems = {{ count($users) }};
            let totalPages = Math.ceil(totalItems / itemsPerPage);
            let currentPage = 1;
            let allItems = Array.from(document.querySelectorAll('#myTable tbody tr'));
            let filteredItems = allItems;

            function paginate(page) {
                currentPage = page;
                let start = (currentPage - 1) * itemsPerPage;
                let end = start + itemsPerPage;

                // Hide all rows
                allItems.forEach(row => row.style.display = 'none');

                // Show filtered rows
                filteredItems.slice(start, end).forEach(row => row.style.display = '');

                // Update pagination controls
                updatePaginationControls();

                // Update info text
                document.getElementById('tableInfo').innerText =
                    `Showing ${start + 1} to ${Math.min(end, filteredItems.length)} of ${filteredItems.length} entries`;
            }

            function updatePaginationControls() {
                let pagination = document.getElementById('pagination');
                pagination.innerHTML = '';

                // Previous button
                let prevPageItem = document.createElement('li');
                prevPageItem.className = 'page-item' + (currentPage === 1 ? ' disabled' : '');
                prevPageItem.innerHTML = `<a class="page-link" href="#">Previous</a>`;
                prevPageItem.addEventListener('click', function() {
                    if (currentPage > 1) paginate(currentPage - 1);
                });
                pagination.appendChild(prevPageItem);

                // Page numbers
                for (let i = 1; i <= totalPages; i++) {
                    let pageItem = document.createElement('li');
                    pageItem.className = 'page-item' + (i === currentPage ? ' active' : '');
                    pageItem.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                    pageItem.addEventListener('click', function() {
                        paginate(i);
                    });
                    pagination.appendChild(pageItem);
                }

                // Next button
                let nextPageItem = document.createElement('li');
                nextPageItem.className = 'page-item' + (currentPage === totalPages ? ' disabled' : '');
                nextPageItem.innerHTML = `<a class="page-link" href="#">Next</a>`;
                nextPageItem.addEventListener('click', function() {
                    if (currentPage < totalPages) paginate(currentPage + 1);
                });
                pagination.appendChild(nextPageItem);
            }

            function filterTable() {
                let filter = document.getElementById('searchInput').value.toLowerCase();
                filteredItems = allItems.filter(row => row.textContent.toLowerCase().includes(filter));
                totalPages = Math.ceil(filteredItems.length / itemsPerPage);
                paginate(1);
            }

            document.getElementById('itemsPerPage').addEventListener('change', function() {
                itemsPerPage = parseInt(this.value);
                totalPages = Math.ceil(filteredItems.length / itemsPerPage);
                paginate(1);
            });

            document.getElementById('searchInput').addEventListener('input', filterTable);

            // Initial pagination
            paginate(1);
        });
    </script>
@endsection
