

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

            </div>
            @include('courses.partials.tasks')
        </div>
    </div>
</div>
@endsection
