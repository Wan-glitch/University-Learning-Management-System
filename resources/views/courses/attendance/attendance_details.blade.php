@extends('layout.app')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/course-style.css') }}">
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <input type="hidden" name="course_id" value="{{ $course->id }}" id="course_id">
            @include('courses.partials.sidebar')
            <div class="col-lg-7 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h3>QR Code generated at: {{ $qrCode->generated_at }}</h3>
                        <h3>Expires at: {{ $qrCode->expires_at }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Student Email</th>
                                        <th>Attendance Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($qrCode->attendances->isEmpty())
                                    <tr>
                                        <td colspan="3" class="text-center">No students attended</td>
                                    </tr>
                                    @else
                                    @foreach($qrCode->attendances as $attendance)
                                    <tr>
                                        <td>{{ $attendance->user->name }}</td>
                                        <td>{{ $attendance->user->email }}</td>
                                        <td>{{ $attendance->attendance_date }}</td>
                                        <td>
                                            <form action="{{ route('attendance.delete', ['attendance' => $attendance->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
