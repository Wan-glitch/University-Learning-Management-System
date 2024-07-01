@extends('layout.app')

@section('content')
<div class="container">
    <h3>Manual Attendance Sign-In for {{ $course->name }}</h3>
    <form action="{{ route('attendance.storeManual', ['course' => $course->id]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit Attendance</button>
    </form>
</div>
@endsection
