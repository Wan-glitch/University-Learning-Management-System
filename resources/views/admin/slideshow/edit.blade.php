@extends('layout.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Edit Slideshow Image</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.slideshow.update', $slideshow->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="caption">Caption</label>
                    <input type="text" name="caption" class="form-control" value="{{ $slideshow->caption }}">
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" class="form-control">
                    <small>Leave blank if you don't want to change the image.</small>
                </div>
                <div class="form-group">
                    <label for="is_active">Active</label>
                    <input type="checkbox" name="is_active" value="1" {{ $slideshow->is_active ? 'checked' : '' }}>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
