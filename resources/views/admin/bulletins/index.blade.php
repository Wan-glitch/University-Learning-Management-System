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
        <div class="card-header">
            <h5 class="card-title">Bulletin Management</h5>
            <a href="{{ route('admin.bulletins.create') }}" class="btn btn-primary" style="float:right">Create Bulletin</a>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Faculty</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bulletins as $bulletin)
                    <tr>
                        <td>{{ $loop->iteration}}</td>
                        <td>{{ $bulletin->title }}</td>
                        <td>{{ $bulletin->category }}</td>
                        <td>{{ $bulletin->faculty->title ?? 'N/A' }}</td>
                        <td>{{ $bulletin->createdBy->name }}</td>
                        <td>
                            <a href="{{ route('admin.bulletins.edit', $bulletin->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.bulletins.destroy', $bulletin->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $bulletins->links() }}
        </div>
    </div>
</div>
@endsection
