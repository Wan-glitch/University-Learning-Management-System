@extends('layout.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Add New Slideshow Image</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.slideshow.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="caption" class="form-label">Caption</label>
                    <input type="text" name="caption" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Add Image</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .container {
        margin-top: 20px;
    }
    .card {
        border: none;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        background-color: #007bff;
        color: white;
        padding: 1rem;
        border-bottom: none;
    }
    .card-title {
        margin-bottom: 0;
        font-size: 1.5rem;
        font-weight: 500;
    }
    .form-group label {
        font-weight: bold;
    }
    .form-control {
        border-radius: 0.25rem;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
</style>
@endpush
