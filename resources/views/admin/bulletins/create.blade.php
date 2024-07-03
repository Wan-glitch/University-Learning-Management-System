@extends('layout.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Create Bulletin</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.bulletins.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-7 col-md-6 col-12 mb-3 mt-3">
                                    <label class="form-label" for="title">Title</label>
                                    <input type="text" name="title" class="form-control" required>
                                </div>
                                <div class="col-lg-7 col-md-6 col-12 mb-3 mt-3">

                                    <label for="content">Content</label>
                                    <textarea name="content" class="form-control" rows="5" required></textarea>
                                </div>
                                <div class="col-lg-7 col-md-6 col-12 mb-3 mt-3">
                                    <label for="category">Category</label>
                                    <select name="category" class="form-control" required>
                                        <option value="Reminder">Reminder</option>
                                        <option value="Faculty">Faculty</option>
                                        <option value="Bulletin">Bulletin</option>
                                    </select>
                                </div>
                                <div class="col-lg-7 col-md-6 col-12 mb-3 mt-3">
                                    <label for="faculty_id">Faculty</label>
                                    <select name="faculty_id" class="form-control">
                                        <option value="">None</option>
                                        @foreach ($faculties as $faculty)
                                            <option value="{{ $faculty->id }}">{{ $faculty->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-7 col-md-6 col-12 mb-3 mt-3">
                                    <label for="recipients">Recipients</label>
                                    <select name="recipients[]" class="form-control" multiple>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-7 col-md-6 col-12 mb-3 mt-3">
                                    <label for="attachments">Attachments</label>
                                    <input type="file" name="attachments[]" class="form-control" multiple>
                                </div>
                                <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

 @endsection
