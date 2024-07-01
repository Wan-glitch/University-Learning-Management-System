@extends('layout.app')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/course-style.css') }}">

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
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">

            @include('courses.partials.sidebar')
            <div class="col-lg-7 mb-4">

                <div class="card">
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
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                                    <i class="bx bx-plus me-0 me-sm-1"></i> Add Student
                                </button>
                                @include('courses.partials.add_student_modal', ['studentsList' => $studentsList])
                            </div>
                        </div>
                        <table class="datatables-users table border-top">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                                    {{-- <a href="{{ route('course.student.show', $student->id) }}" class="dropdown-item">View</a> --}}
                                                    <form action="{{ route('course.removeStudent', [$course->id, $student->id]) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to remove this student?')">Remove</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-between align-items-center" style="margin:1%">
                            <div>{{ $students->links() }}</div>
                        </div>
                    </div>
                </div>

            </div>

            @include('courses.partials.tasks')
        </div>
    </div>
</div>

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
