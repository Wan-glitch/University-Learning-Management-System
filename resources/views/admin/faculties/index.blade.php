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
    .table-responsive {
        padding: 1rem;
    }
    .table th, .table td {
        vertical-align: middle;
    }
    .btn-icon {
        padding: 0.5em;
    }
    .dropdown-menu-end {
        right: 0;
        left: auto;
    }
</style>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Faculties</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createFacultyModal" style="float: right">Add New Faculty</button>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>PIC</th>
                        <th>Courses</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($faculties as $faculty)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $faculty->title }}</td>
                        <td>{{ $faculty->description }}</td>
                        <td>{{ $faculty->hasPIC->name ?? 'Not Assigned' }}</td>
                        <td>
                            @if ($faculty->courses->isEmpty())
                                No Courses Assigned
                            @else
                                @foreach ($faculty->courses as $course)
                                    <span class="badge bg-primary">{{ $course->name }}</span>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editFacultyModal{{ $faculty->id }}">Edit</button>
                            <form action="{{ route('admin.faculties.destroy', $faculty->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Faculty Modal -->
                    <div class="modal fade" id="editFacultyModal{{ $faculty->id }}" tabindex="-1" aria-labelledby="editFacultyModalLabel{{ $faculty->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editFacultyModalLabel{{ $faculty->id }}">Edit Faculty</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.faculties.update', $faculty->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" name="title" class="form-control" value="{{ $faculty->title }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea name="description" class="form-control">{{ $faculty->description }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="pic" class="form-label">Person in Charge (PIC)</label>
                                            <select name="pic" class="form-select">
                                                <option value="">Select PIC</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}" {{ $faculty->pic == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Faculty Modal -->
<div class="modal fade" id="createFacultyModal" tabindex="-1" aria-labelledby="createFacultyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createFacultyModalLabel">Create Faculty</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.faculties.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="pic" class="form-label">Person in Charge (PIC)</label>
                        <select name="pic" class="form-select">
                            <option value="">Select PIC</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="courses">Courses</label>
                        <select name="courses[]" class="form-select" multiple>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="status">Status</label>
                        <select name="status" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Faculty</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
