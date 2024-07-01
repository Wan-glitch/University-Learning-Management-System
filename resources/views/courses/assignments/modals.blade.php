<style>
    .modal-fullscreen {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        max-width: none;
    }

    .file-item {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    }

    .file-item .file-icon {
        margin-right: 10px;
        font-size: 24px;
    }
</style>


<!-- Modal for Creating Assignment -->
<div class="modal fade" id="createAssignmentModal" tabindex="-1" role="dialog" aria-labelledby="createAssignmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="createAssignmentForm" method="POST" action="{{ route('courses.assignments.create', $course->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createAssignmentModalLabel">Create Assignment</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
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



<div class="modal fade" id="assignmentModal" tabindex="-1" role="dialog" aria-labelledby="assignmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="assignmentModalDialog" role="document">
        <div class="modal-content">
            <form id="updateAssignmentForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Method spoofing for PUT requests -->
                <div class="modal-header">
                    <h5 class="modal-title" id="assignmentModalLabel">Assignment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Toggle Button -->
                    <button type="button" class="btn btn-primary mb-3" id="toggle-view-btn">View Submissions</button>

                    <!-- Assignment Details Section -->
                    <div id="assignment-details">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="view_title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="view_description" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="due_date">Due Date</label>
                            <input type="date" class="form-control" id="view_due_date" name="due_date" required>
                        </div>
                        <div class="form-group">
                            <label for="due_time">Due Time</label>
                            <input type="time" class="form-control" id="view_due_time" name="due_time" required>
                        </div>
                        <div class="form-group">
                            <label for="files">Files</label>
                            <div id="existing_files"></div>
                        </div>
                        <div class="form-group">
                            <label for="new_files">Upload New Files</label>
                            <input type="file" class="form-control" id="new_files" name="files[]" multiple>
                        </div>
                    </div>

                    <!-- Submissions Section -->
                    <div id="submissions-view" style="display:none;">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>Submission Date</th>
                                    <th>Files</th>
                                </tr>
                            </thead>
                            <tbody id="submissionsTableBody">
                                <!-- Submissions will be dynamically loaded here -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Assignment Submission Section -->
                    <div id="assignment-submission" style="display:none;">
                        <div class="form-group">
                            <label for="submission_files">Upload Submission Files</label>
                            {{-- <input type="file" class="form-control" id="submissoin_files" name="submission_files[]" multiple> --}}
                            <input id="submissoin_files" type="file" class="form-control" data-preview-file-type="text" name="submission_files[]" multiple>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button type="submit" class="btn btn-primary" id="update-assignment-btn">Update Assignment</button>
                    <button type="submit" class="btn btn-primary" id="submit-assignment-btn" style="display:none;">Submit Assignment</button>
                </div>
            </form>
        </div>
    </div>
</div>
