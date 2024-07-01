@extends('layout.app')

@section('content')
<!-- Content -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link href="{{ asset('css/tasks.css') }}" rel="stylesheet">
</style>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-9 mb-5">
                <!-- Courses where the user is the person-in-charge -->
                @if($picCourses->isNotEmpty())
                    <div>
                        <h5>Courses In-Charge</h5>
                        <div class="row">
                            @foreach($picCourses as $course)
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('courses.show', $course) }}" class="card h-100 card-custom">
                                    <img class="card-img-top" src="{{ asset('assets/img/elements/2.jpg') }}" alt="Card image cap" />
                                    <div class="card-body card-body-custom">
                                        <h5 class="card-title card-title-custom">{{ $course->name }}</h5>
                                        <p class="card-text card-text-custom">
                                            {{ \Str::words($course->description, 15) }}
                                        </p>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Courses the user is enrolled in -->
                <div>
                    <h5>Enrolled Courses</h5>
                    <div class="row">
                        @foreach($courses as $course)
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('courses.show', $course) }}" class="card h-100 card-custom">
                                <img class="card-img-top" src="{{ asset('assets/img/elements/2.jpg') }}" alt="Card image cap" />
                                <div class="card-body card-body-custom">
                                    <h5 class="card-title card-title-custom">{{ $course->name }}</h5>
                                    <p class="card-text card-text-custom">
                                        {{ \Str::words($course->description, 15) }}
                                    </p>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Tasks Section -->
            <div class="col-lg-3 col-md-6 col-12">
                <div class="tasks-custom">
                    <h3 style="border-bottom: 1px solid #dee2e6;">Tasks</h3>
                    @foreach($tasks as $courseName => $courseTasks)
                        <div class="course-group" style="border-bottom: 1px solid #dee2e6;">
                            <h5>{{ $courseName }}</h5>
                            @foreach($courseTasks as $task)
                                <div class="task-custom">
                                    <div>
                                        <strong>{{ $task->title }}</strong><br>
                                    </div>
                                    <div>
                                        @if(\Carbon\Carbon::parse($task->due_date)->isPast())
                                            <span class="text-danger">{{ \Carbon\Carbon::parse($task->due_date)->format('d M, H:i') }}</span>
                                        @else
                                            <span>{{ \Carbon\Carbon::parse($task->due_date)->format('d M, H:i') }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
