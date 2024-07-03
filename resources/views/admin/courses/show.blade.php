@extends('layouts.admin')

@section('content')
<h1>{{ $course->name }}</h1>
<p>{{ $course->description }}</p>
<p><strong>PIC:</strong> {{ $course->pic ? $course->pic->name : 'No PIC Assigned' }}</p>
<p><strong>Faculty:</strong> {{ $course->faculty ? $course->faculty->title : 'No Faculty Assigned' }}</p>
<p><strong>Status:</strong> {{ $course->status == 1 ? 'Active' : 'Inactive' }}</p>
<a href="{{ route('admin.courses.index') }}" class="btn btn-primary">Back to Courses</a>
@endsection
