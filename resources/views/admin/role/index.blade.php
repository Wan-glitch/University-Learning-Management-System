@extends('layout.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">

            <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify@4.17.9/dist/tagify.min.js"></script>
            <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify@4.17.9/dist/tagify.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
            <style>
                .dataTable-sorter::before {
                    bottom: 8px;
                }

                .dataTable-sorter::after {
                    top: 8px;
                }


                .card {
                    height: 160px;
                }
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
    .table th, .table td {
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
            </style>

            <div class="col-md-6 col-md-12 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-8" style="padding-bottom: 20px">
                                    <h5 class="card-title m-0 me-2">Roles </h5>
                                </div>
                                <div class="row">
                                    @foreach ($rolesWithUserCounts as $role)
                                        {{-- <div class="col-xl-4 col-lg-6 col-md-6" style="padding-bottom: 20px; cursor: pointer;" onclick="window.location.href='{{ route('admin.roles.show', ['role' => $role->id]) }}';"> --}}
                                        <div class="col-xl-4 col-lg-6 col-md-6"
                                            style="padding-bottom: 20px; cursor: pointer;">

                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <span style="color: #696cff;">Total {{ $role->users->count() }} users</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-end mt-1 pt-25">
                                                        <div class="role-heading">
                                                            <h4 class="fw-bolder">{{ ucfirst($role->name) }}</h4>
                                                            @if ($role->role_status == 1)
                                                                <span class="badge bg-label-success me-1">Active</span>
                                                            @elseif ($role->role_status == 0)
                                                                <span class="badge bg-label-success me-1">Inactive</span>
                                                            @endif
                                                            <br>
                                                            @if (Auth::user()->role == $role->id)
                                                            @else
                                                                <div class="d-flex justify-content-between align-items-center" style="margin-top: 5px;">
                                                                    <a href="{{ route('admin.roles.edit', ['role' => $role->id]) }}" class="fw-bolder">Edit Role</a>
                                                                    @can('Update Role')
                                                                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="button"
                                                                                    class="btn btn-danger btn-sm ms-2"
                                                                                    @if(in_array($role->id, [1, 2, 3]))

                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-placement="top"
                                                                                        title="You cannot delete Core Role"
                                                                                        onclick="showErrorMessage()"
                                                                                    @else
                                                                                        onclick="deleteConfirmation(event)"
                                                                                    @endif
                                                                            >Delete</button>
                                                                        </form>
                                                                    @endcan
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <a href="javascript:void(0);" class="text-body"><i data-feather="copy" class="font-medium-5"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @can('Create Role')
                                        <div class="col-xl-4 col-lg-6 col-md-6" style="padding-bottom: 20px; cursor: pointer;">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-5">
                                                            <div class="d-flex align-items-end justify-content-center h-100">
                                                                <img src="{{ asset('images/illustration/faq-illustrations.svg') }}"
                                                                    class="img-fluid mt-2" alt="Image" width="85" />
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-7">
                                                            <div class="card-body text-sm-end text-center ps-sm-0">
                                                                <a href="{{ route('admin.roles.create') }}"
                                                                    class="stretched-link text-nowrap add-new-role">
                                                                    <span class="btn btn-primary mb-1">Add New Role</span>
                                                                </a>
                                                                <p class="mb-0">Add role, if it does not exist</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-md-6 col-md-12 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-body border-bottom">
                        <h4 class="card-title" style="margin:10px">Users Table</h4>
                        <div class="row">
                            @can('Update Role')
                                <button type="button" id="assignRoleButton" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#assignRoleModal">Assign Role</button>
                            @endcan
                            <div class="col-md-4 user_role"></div>
                            <div class="col-md-4 user_plan"></div>
                            <div class="col-md-4 user_status"></div>
                        </div>
                    </div>

                    <div class="card-datatable table-responsive">
                        <div class="d-flex justify-content-between align-items-center mb-3" style="margin:10px">
                            <div class="me-3">
                                <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0"
                                    class="form-select" id="itemsPerPage" style="margin:10px">
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
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCourseModal">
                                    <i class="bx bx-plus me-0 me-sm-1"></i> New User
                                </button>

                            </div>
                        </div>
                        <table id="myTable" class="datatables-users table border-top">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton{{ $user->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">Actions</button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $user->id }}">
                                                <li><a class="dropdown-item" href="{{ route('admin.users.show', $user->id) }}">View</a></li>
                                                <li>
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item"
                                                            onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-between align-items-center" style="margin:1%">
                            <div id="tableInfo">Showing 1 to 10 of {{ $users->total() }} entries</div>
                            <nav>
                                <ul class="pagination" id="pagination">
                                    {{ $users->links() }}
                                </ul>
                            </nav>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

            <script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            "pagingType": "simple_numbers",
            "lengthChange": false,
            "pageLength": 10,
            "searching": true,
            "info": true,
            "dom": '<"top"i>rt<"bottom"p><"clear">',
            "language": {
                "paginate": {
                    "previous": "Previous",
                    "next": "Next"
                }
            }
        });

        $('#itemsPerPage').on('change', function() {
            var table = $('#myTable').DataTable();
            table.page.len($(this).val()).draw();
        });

        $('#searchInput').on('keyup', function() {
            var table = $('#myTable').DataTable();
            table.search($(this).val()).draw();
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    function showErrorMessage() {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'You cannot delete Core Role',
        });
    }

    function deleteConfirmation(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this role!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.closest('form').submit();
            }
        });
    }
            </script>
        </div>
    </div>
@endsection
