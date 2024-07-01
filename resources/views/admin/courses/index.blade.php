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
            <h5 class="card-title">Courses</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCourseModal">Add New Course</button>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Faculty</th>
                        <th>PIC</th>

                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($courses->isEmpty())
                        <tr>
                            <td colspan="9" style="text-align:center">NOT DATA AVAILABLE</td>
                        </tr>
                    @else
                    @foreach ($courses as $course)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->description }}</td>
                        <td>{{ $course->hasFaculty->title ?? 'Not Assigned' }}</td>
                        <td>{{ $course->hasPIC->name ?? 'Not Assigned' }}</td>

                        <td>
                            @if ($course->status == 1)
                                <span class="badge bg-label-success me-1">Active</span>
                            @else
                                <span class="badge bg-label-secondary me-1">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editCourseModal{{ $course->id }}">Edit</button>
                            <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Course Modal -->
                    <div class="modal fade" id="editCourseModal{{ $course->id }}" tabindex="-1" aria-labelledby="editCourseModalLabel{{ $course->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editCourseModalLabel{{ $course->id }}">Edit Course</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.courses.update', $course->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control" value="{{ $course->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea name="description" class="form-control">{{ $course->description }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="faculty" class="form-label">Faculty</label>
                                            <select name="faculty" class="form-select">
                                                <option value="">Select Faculty</option>
                                                @foreach ($faculties as $faculty)
                                                    <option value="{{ $faculty->id }}" {{ $course->faculty == $faculty->id ? 'selected' : '' }}>{{ $faculty->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="pic" class="form-label">Person in Charge (PIC)</label>
                                            <select name="pic" class="form-select">
                                                <option value="">Select PIC</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}" {{ $course->pic == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select name="status" class="form-select">
                                                <option value="1" {{ $course->status == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ $course->status == 0 ? 'selected' : '' }}>Inactive</option>
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
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Course Modal -->
<div class="modal fade" id="createCourseModal" tabindex="-1" aria-labelledby="createCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCourseModalLabel">Create Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.courses.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="faculty" class="form-label">Faculty</label>
                        <select name="faculty" class="form-select">
                            <option value="">Select Faculty</option>
                            @foreach ($faculties as $faculty)
                                <option value="{{ $faculty->id }}">{{ $faculty->title }}</option>
                            @endforeach
                        </select>
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
                    <div class="mb-3">
                        <label for="year" class="form-label">Year</label>
                        <input type="number" name="year" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="term" class="form-label">Term</label>
                        <select name="term" class="form-select">
                            <option value="">Select Term</option>
                            <option value="1">Term 1</option>
                            <option value="2">Term 2</option>
                            <option value="3">Term 3</option>
                            <option value="4">Term 4</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Course</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
