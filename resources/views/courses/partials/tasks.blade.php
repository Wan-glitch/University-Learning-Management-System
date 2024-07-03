<style>
    .text-danger {
        color: red;
    }
    .task-custom + .task-custom {
        border-top: 1px solid #dee2e6;
        padding-top: 10px;
        margin-top: 10px;
    }
    .task-link {
    text-decoration: none; /* Remove underline from links */
    color: inherit; /* Inherit text color */
    display: block; /* Make the anchor tag block-level to wrap the entire task */
    margin-bottom: 10px; /* Add some space between tasks */
}

.task-link:hover .task-custom {
    background-color: #f0f0f0; /* Change background color on hover */
    border-radius: 8px; /* Add rounded corners */
    transition: background-color 0.3s ease; /* Smooth transition */
}

</style>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<div class="col-lg-3 col-md-6 col-12">
    <div class="tasks-custom ">
        <h3>Tasks for {{ $course->name }}</h3>
        @foreach($tasks as $task)
        <div class="task-link" data-id="{{ $task->id }}" data-title="{{ $task->title }}" data-description="{{ $task->description }}" data-due-date="{{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') }}" data-due-time="{{ \Carbon\Carbon::parse($task->due_date)->format('H:i') }}">
            <div class="task-custom">
                <div>
                    <strong>{{ $task->title }}</strong>
                </div>
                <div>
                    @if(\Carbon\Carbon::parse($task->due_date)->isPast())
                        <span class="text-danger">{{ \Carbon\Carbon::parse($task->due_date)->format('d M, H:i') }}</span>
                    @else
                        <span>{{ \Carbon\Carbon::parse($task->due_date)->format('d M, H:i') }}</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal for Viewing Assignment Details -->
<!-- Modal for Viewing Assignment Details -->
<div class="modal fade" id="assignmentModal" tabindex="-1" role="dialog" aria-labelledby="assignmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignmentModalLabel">Assignment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="modal_title">Title</label>
                    <p id="modal_title" class="form-control-plaintext"></p>
                </div>
                <div class="form-group">
                    <label for="modal_description">Description</label>
                    <p id="modal_description" class="form-control-plaintext"></p>
                </div>
                <div class="form-group">
                    <label for="modal_due_date">Due Date</label>
                    <p id="modal_due_date" class="form-control-plaintext"></p>
                </div>
                <div class="form-group">
                    <label for="modal_due_time">Due Time</label>
                    <p id="modal_due_time" class="form-control-plaintext"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const taskLinks = document.querySelectorAll('.task-link');

        taskLinks.forEach(link => {
            link.addEventListener('click', function() {
                const taskId = this.getAttribute('data-id');
                const taskTitle = this.getAttribute('data-title');
                const taskDescription = this.getAttribute('data-description');
                const taskDueDate = this.getAttribute('data-due-date');
                const taskDueTime = this.getAttribute('data-due-time');

                // Populate modal with task data
                document.getElementById('modal_title').textContent = taskTitle;
                document.getElementById('modal_description').textContent = taskDescription;
                document.getElementById('modal_due_date').textContent = taskDueDate;
                document.getElementById('modal_due_time').textContent = taskDueTime;

                // Show the modal
                const assignmentModal = new bootstrap.Modal(document.getElementById('assignmentModal'));
                assignmentModal.show();
            });
        });
    });
</script>
