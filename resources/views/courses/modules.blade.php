@extends('layout.app')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/course-style.css') }}">

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            @include('courses.partials.sidebar')
            <div class="col-lg-7 mb-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Lecture</h5>
                        <div class="file-list">
                            @foreach ($course->lectures as $lecture)
                                <div class="file-item">
                                    <img src="{{ asset('images/ppt-icon.png') }}" alt="PPT Icon">
                                    <a href="{{ route('courses.download-lecture', ['course' => $course, 'lecture' => $lecture]) }}" target="_blank">{{ $lecture->name }}</a>
                                </div>
                            @endforeach
                        </div>
                        <form action="{{ route('courses.upload-lecture', $course) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="lecture_file" accept=".pdf,.doc,.docx,.ppt,.pptx">
                            <button type="submit" class="btn btn-outline-primary"><i class="fas fa-upload"></i> Upload Lecture</button>
                        </form>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Tutorial / Lab</h5>
                        <div class="file-list">
                            @foreach ($course->tutorials as $tutorial)
                                <div class="file-item">
                                    <img src="{{ asset('images/pdf-icon.png') }}" alt="PDF Icon">
                                    <span>{{ $tutorial->name }}</span>
                                </div>
                            @endforeach
                        </div>
                        <form action="{{ route('courses.upload-tutorial', $course) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="tutorial_file" accept=".pdf,.doc,.docx,.ppt,.pptx">
                            <button type="submit" class="btn btn-outline-primary"><i class="fas fa-upload"></i> Upload Tutorial</button>
                        </form>
                    </div>
                </div>
                <button class="btn btn-primary download-btn">
                    <i class="fas fa-download"></i> Download
                </button>
            </div>
            @include('courses.partials.tasks')
        </div>
    </div>
</div>

@endsection
