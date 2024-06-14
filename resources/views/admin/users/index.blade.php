<!-- resources/views/user_management.blade.php -->
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

<div class="container mt-5">
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title">Search Filter</h5>
            <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                <div class="col-md-4 user_role">
                    <select id="UserRole" class="form-select text-capitalize">
                        <option value=""> Select Role </option>
                        <option value="Admin">Admin</option>
                        <option value="Author">Lecturer</option>
                        <option value="Editor">Student</option>
                    </select>
                </div>
                <div class="col-md-4 user_plan">
                    <select id="UserPlan" class="form-select text-capitalize">
                        <option value=""> Select Faculty </option>
                        <option value="Basic">FCI</option>
                        <option value="Company">FCM</option>
                        <option value="Enterprise">FCA</option>
                        <option value="Team">FOM</option>
                    </select>
                </div>
                <div class="col-md-4 user_status">
                    <select id="FilterTransaction" class="form-select text-capitalize">
                        <option value=""> Select Status </option>
                        <option value="Active" class="text-capitalize">Active</option>
                        <option value="Inactive" class="text-capitalize">Inactive</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="me-3">
                    <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="form-select">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="d-flex">
                    <input type="search" class="form-control" style="width: auto !important" placeholder="Search.." aria-controls="DataTables_Table_0">
                    <a href="{{ route('users.export') }}" class="btn btn-label-secondary mx-3">
                        <i class="bx bx-export me-1"></i>Export
                    </a>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="bx bx-plus me-0 me-sm-1"></i> Add New User
                    </button>
                    @include('admin.users.modals.add_user_modal') <!-- Updated path for including the modal -->
                </div>
            </div>
            <table class="datatables-users table border-top">
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
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ Str::ucfirst($user->role ? $user->GotRole->name : 'No Role Assigned' )}}</td>
                            <td>
                                @if ($user->faculty==NULL)
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
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="dropdown-item">View</a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-between align-items-center" style="margin:1%">
                <div>Showing 1 to 10 of 50 entries</div>
                <nav>
                    <ul class="pagination">
                        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- At the end of the blade file -->
@push('scripts')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.datatables-users').DataTable();
        });

        // Form submission handling for single user
        $("#singleUserForm").submit(function(e){
            e.preventDefault(); // Prevent default form submission

            // Submit the form via AJAX
            $.ajax({
                type: "POST",
                url: "{{ route('admin.users.store') }}",
                data: $(this).serialize(),
                success: function(response) {
                    // Handle success response
                    console.log(response);
                    $('#addUserModal').modal('hide'); // Hide the modal
                    // You can display success message or do other actions
                    location.reload(); // Reload the page to see the new user
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error(xhr.responseText);
                    // You can display error message or do other actions
                }
            });
        });
    </script>
@endpush

@endsection
