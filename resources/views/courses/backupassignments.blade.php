@extends('layout.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/course-style.css') }}">

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            @include('courses.partials.sidebar')
            <div class="col-lg-9 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>{{ $title }} - Assignments</h4>
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#createAssignmentModal">+ Create Assignment</a>
                </div>
                @foreach($assignments as $assignment)
                <div class="assignment-card mb-3 p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>{{ $assignment->title }}</h5>
                        <span>Due {{ \Carbon\Carbon::parse($assignment->due_date)->format('d F, H:i') }}</span>
                    </div>
                    <p>{{ $assignment->description }}</p>
                    <a href="#" class="btn btn-link view-details" data-id="{{ $assignment->id }}" data-course-id="{{ $course->id }}">View Details</a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Modal for Creating Assignment -->
<div class="modal fade" id="createAssignmentModal" tabindex="-1" role="dialog" aria-labelledby="createAssignmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="createAssignmentForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createAssignmentModalLabel">Create Assignment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="due_date">Due Date</label>
                        <input type="date" class="form-control" id="due_date" name="due_date" required>
                    </div>
                    <div class="form-group">
                        <label for="due_time">Due Time</label>
                        <input type="time" class="form-control" id="due_time" name="due_time" required>
                    </div>
                    <div class="form-group">
                        <label for="files">Upload Files</label>
                        <input type="file" class="form-control" id="files" name="files[]" multiple>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Assignment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Viewing Assignment Details -->
<div class="modal fade" id="assignmentModal" tabindex="-1" role="dialog" aria-labelledby="assignmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignmentModalLabel">Assignment Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Assignment details will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.view-details').on('click', function(e) {
        e.preventDefault();
        var assignmentId = $(this).data('id');
        var courseId = $(this).data('course-id');
        $.ajax({
            url: '/courses/' + courseId + '/assignments/' + assignmentId,
            method: 'GET',
            success: function(response) {
                $('#assignmentModal .modal-body').html(response);
                $('#assignmentModal').modal('show');
            },
            error: function(response) {
                alert('An error occurred while fetching the assignment details.');
            }
        });
    });

    $('#createAssignmentForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var courseId = $('input[name="course_id"]').val();
        $.ajax({
            url: '/courses/' + courseId + '/assignments',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#createAssignmentModal').modal('hide');
                location.reload(); // Reload the page to see the new assignment
            },
            error: function(response) {
                alert('An error occurred while creating the assignment.');
            }
        });
    });

    $(document).on('submit', '#submitAssignmentForm', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var assignmentId = $('#submitAssignmentForm').data('assignment-id');
        var courseId = $('input[name="course_id"]').val();
        $.ajax({
            url: '/courses/' + courseId + '/assignments/' + assignmentId + '/submit',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert('Assignment submitted successfully.');
                $('#assignmentModal').modal('hide');
            },
            error: function(response) {
                console.log(response);
                if(response.status === 422) {
                    var errors = response.responseJSON.errors;
                    var errorMessage = "An error occurred while submitting the assignment:\n";
                    $.each(errors, function(key, value) {
                        errorMessage += value + "\n";
                    });
                    alert(errorMessage);
                } else {
                    alert('An error occurred while submitting the assignment.');
                }
            }
        });
    });
});
</script>
@endsection
