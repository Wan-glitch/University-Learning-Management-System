@extends('layout.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>







    <link rel="stylesheet" href="{{ asset('css/course-style.css') }}">
    <style>
        .text-danger {
            color: red;
        }

        .btn-close {
    /* Basic styles for the button */
    background-color: transparent;
    border: none;
    cursor: pointer;
    position: relative;
    padding: 0;
    outline: none;
}

.btn-close:hover {
    /* Glow effect on hover */
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.7);
    filter: brightness(1.2);
    transition: all 0.3s ease-in-out;
}
    </style>
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                @include('courses.partials.sidebar')
                <div class="col-lg-9 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4>{{ $title }} - Assignments</h4>
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#createAssignmentModal">+
                            Create Assignment</a>
                    </div>
                    @foreach ($assignments as $assignment)
                        <div class="assignment-card mb-3 p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5>{{ $assignment->title }}</h5>
                                @if (\Carbon\Carbon::parse($assignment->due_date)->isPast())
                                    <span class="text-danger">Due
                                        {{ \Carbon\Carbon::parse($assignment->due_date)->format('d F, H:i') }}</span>
                                @else
                                    <span>Due {{ \Carbon\Carbon::parse($assignment->due_date)->format('d F, H:i') }}</span>
                                @endif
                            </div>
                            <p>{{ $assignment->description }}</p>
                            <a href="#" class="btn btn-link view-details" data-id="{{ $assignment->id }}"
                                data-course-id="{{ $course->id }}">View Details</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @include('courses.assignments.modals')


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const baseUrl =
                `{{ route('courses.assignments.show', ['course' => '__courseId__', 'id' => '__assignmentId__']) }}`;

            document.querySelectorAll('.view-details').forEach(button => {
                button.addEventListener('click', function() {
                    const assignmentId = this.getAttribute('data-id');
                    const courseId = this.getAttribute('data-course-id');
                    const url = baseUrl.replace('__courseId__', courseId).replace(
                        '__assignmentId__', assignmentId);

                    fetch(url)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            const assignment = data.assignment;
                            const isPersonInCharge = data.isPersonInCharge;
                            const submissions = data.submissions; // Submissions data

                            document.getElementById('view_title').value = assignment.title;
                            document.getElementById('view_description').value = assignment
                                .description;
                            document.getElementById('view_due_date').value = assignment.due_date
                                .split(' ')[0];
                            document.getElementById('view_due_time').value = assignment.due_date
                                .split(' ')[1];

                            const existingFilesContainer = document.getElementById(
                                'existing_files');
                            existingFilesContainer.innerHTML = '';
                            assignment.files.forEach(file => {
                                const fileElement = document.createElement('div');
                                fileElement.classList.add('file-item');
                                fileElement.innerHTML = `
                            <a href="${file.url}" target="_blank">${file.name}</a>
                            ${isPersonInCharge ? `<button type="button" class="btn-close delete-file" data-file-id="${file.id}"></button>` : ''}
                        `;
                                existingFilesContainer.appendChild(fileElement);
                            });

                            const modalDialog = document.getElementById(
                            'assignmentModalDialog');
                            if (isPersonInCharge) {
                                modalDialog.classList.add('modal-fullscreen');
                                document.getElementById('assignment-details').style.display =
                                    'block';
                                document.getElementById('assignment-submission').style.display =
                                    'none';
                                document.getElementById('update-assignment-btn').style.display =
                                    'inline-block';
                                document.getElementById('submit-assignment-btn').style.display =
                                    'none';
                                document.getElementById('updateAssignmentForm').action =
                                    `/courses/${courseId}/assignments/${assignmentId}`;
                                document.querySelector(
                                        '#updateAssignmentForm input[name="_method"]').value =
                                    'PUT';
                            } else {
                                modalDialog.classList.remove('modal-fullscreen');
                                document.getElementById('assignment-details').style.display =
                                    'none';
                                document.getElementById('assignment-submission').style.display =
                                    'block';
                                document.getElementById('update-assignment-btn').style.display =
                                    'none';
                                document.getElementById('submit-assignment-btn').style.display =
                                    'inline-block';
                                document.getElementById('updateAssignmentForm').action =
                                    `/courses/${courseId}/assignments/${assignmentId}/submit`;
                                document.querySelector(
                                        '#updateAssignmentForm input[name="_method"]').value =
                                    'POST';
                            }

                            // Populate submissions table
                            const submissionsTableBody = document.getElementById(
                                'submissionsTableBody');
                            submissionsTableBody.innerHTML = '';
                            submissions.forEach(submission => {
                                const submissionRow = document.createElement('tr');
                                submissionRow.innerHTML = `
                            <td>${submission.user_name}</td>
                            <td>${new Date(submission.submission_date).toLocaleString()}</td>
                            <td>${submission.files && submission.files.length > 0 ? submission.files.map(file => `<a href="${file.url}" target="_blank">${file.name}</a>`).join('<br>') : 'No files'}</td>
                        `;
                                submissionsTableBody.appendChild(submissionRow);
                            });

                            $('#assignmentModal').modal('show');
                        })
                        .catch(error => {
                            console.error('There has been a problem with your fetch operation:',
                                error);
                        });
                });
            });

            // Toggle view button
            document.getElementById('toggle-view-btn').addEventListener('click', function() {
                const detailsView = document.getElementById('assignment-details');
                const submissionsView = document.getElementById('submissions-view');
                if (detailsView.style.display === 'none') {
                    detailsView.style.display = 'block';
                    submissionsView.style.display = 'none';
                    this.textContent = 'View Submissions';
                } else {
                    detailsView.style.display = 'none';
                    submissionsView.style.display = 'block';
                    this.textContent = 'View Assignment Details';
                }
            });


            document.getElementById('existing_files').addEventListener('click', function(e) {
                if (e.target.classList.contains('delete-file')) {
                    const fileId = e.target.getAttribute('data-file-id');
                    const courseId = '{{ $course->id }}';
                    const assignmentId = document.getElementById('updateAssignmentForm').action.split('/')
                        .pop();
                    fetch(`/courses/${courseId}/assignments/${assignmentId}/files/${fileId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                e.target.closest('.file-item').remove();
                            }
                        });
                }
            });

        });

    </script>
@endsection
