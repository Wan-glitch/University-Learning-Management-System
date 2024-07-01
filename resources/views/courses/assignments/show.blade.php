<div>
    <h5>{{ $assignment->title }}</h5>
    <p><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($assignment->due_date)->format('d F, H:i') }}</p>
    <p>{{ $assignment->description }}</p>
    @if($assignment->files)
        <h6>Attachments:</h6>
        <ul>
            @foreach(json_decode($assignment->files) as $file)
                <li>
                    @if(in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                        <img src="{{ asset('storage/' . $file) }}" alt="Attachment" style="width: 100px; height: auto;">
                    @elseif(in_array(pathinfo($file, PATHINFO_EXTENSION), ['mp4', 'mov', 'avi', 'wmv']))
                        <video width="320" height="240" controls>
                            <source src="{{ asset('storage/' . $file) }}" type="video/{{ pathinfo($file, PATHINFO_EXTENSION) }}">
                        </video>
                    @else
                        <a href="{{ asset('storage/' . $file) }}" target="_blank"><i class="fas fa-file"></i> Download</a>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif

    <!-- Submission Form -->
    <hr>
    <h6>Submit Your Assignment</h6>
    <form id="submitAssignmentForm" data-assignment-id="{{ $assignment->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="submission_files">Upload Files</label>
            <input type="file" class="form-control" id="submission_files" name="files[]" multiple required>
        </div>
        <button type="submit" class="btn btn-primary">Submit Assignment</button>
    </form>
</div>
