@extends('layout.app')

@section('content')
    <!-- Include the full version of jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/course-style.css') }}">

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                @include('courses.partials.sidebar')
                <div class="col-lg-7 mb-4">
                    @if ($course->students_can_announce || auth()->user()->isLecturer())
                        <form id="announceForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <div class="announce-box" id="announceBox">
                                <textarea placeholder="Announce something to your class" id="announceInput" name="content" oninput="autoExpand(this)"></textarea>
                                <div class="actions">
                                    <div class="attachments">
                                        <label for="fileInput" class="file-input-label">
                                            <i class="fas fa-file"></i>
                                        </label>
                                        <input type="file" id="fileInput" name="attachment" style="display:none;">

                                        <label for="photoInput" class="file-input-label">
                                            <i class="fas fa-photo-video"></i>
                                        </label>
                                        <input type="file" id="photoInput" name="photo" accept="image/*"
                                            style="display:none;">

                                        <label for="videoInput" class="file-input-label">
                                            <i class="fas fa-video"></i>
                                        </label>
                                        <input type="file" id="videoInput" name="video" accept="video/*"
                                            style="display:none;">
                                    </div>
                                    <button type="button" id="postButton" class="btn btn-primary post-button">Post</button>
                                </div>
                            </div>
                        </form>
                    @endif

                    <div class="main-content">
                        @foreach ($announcements as $announcement)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <div class="d-flex align-items-start">
                                            <img src="{{ $announcement->user->profile_photo_url ?? 'default_profile_photo_url' }}"
                                                alt="user" class="rounded-circle me-3" width="40" height="40">
                                            <div>
                                                <h5 class="card-title">{{ $announcement->user->name }}</h5>
                                                <h6 class="card-subtitle text-muted">
                                                    {{ $announcement->created_at->format('d M Y') }}</h6>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-link text-dark" type="button"
                                                id="dropdownMenuButton{{ $announcement->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i data-feather="more-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton{{ $announcement->id }}">
                                                <form action="{{ route('announcements.destroy', $announcement->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item"
                                                        onclick="return confirm('Are you sure you want to delete this announcement?')">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="card-text mt-3">{{ $announcement->content }}</p>
                                    @if ($announcement->attachment)
                                        <a href="{{ Storage::url($announcement->attachment) }}" target="_blank">Download</a>
                                    @endif
                                    @if ($announcement->photo)
                                        <img src="{{ asset('storage/' . $announcement->photo) }}" alt="Photo"
                                            class="img-fluid mt-3">
                                    @endif
                                    @if ($announcement->video)
                                        <video controls class="img-fluid mt-3">
                                            <source src="{{ Storage::url($announcement->video) }}" type="video/mp4">
                                            Your browser does not support the video. Please change your browser.
                                        </video>
                                    @endif
                                    <div class="comments-section mt-3">
                                        <hr>
                                        <h6>Comments</h6>
                                        @if ($announcement->comments->count() == 1)
                                            @foreach ($announcement->comments as $comment)
                                                <div class="d-flex align-items-start mb-2">
                                                    <img src="{{ $comment->user->profile_photo_url ?? 'default_profile_photo_url' }}"
                                                        alt="user" class="rounded-circle me-2" width="40"
                                                        height="40">
                                                    <div>
                                                        <p class="mb-0">{{ $comment->content }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @elseif($announcement->comments->count() > 1)
                                            <a href="#" class="show-comments"
                                                data-announcement-id="{{ $announcement->id }}">{{ $announcement->comments->count() }}
                                                comments</a>
                                        @endif
                                        <div class="d-flex mt-3">
                                            <img src="{{ auth()->user()->profile_photo_url ?? 'default_profile_photo_url' }}"
                                                alt="user" class="rounded-circle me-2" width="40" height="40">
                                            <input type="text" class="form-control comment-input"
                                                placeholder="Write a comment..."
                                                data-announcement-id="{{ $announcement->id }}">
                                            <button type="button" class="btn btn-primary post-comment-button"
                                                style="margin-left: 10px;"
                                                data-announcement-id="{{ $announcement->id }}">
                                                <i data-feather="send" class="feather-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @include('courses.partials.tasks')
            </div>
        </div>
    </div>

    <!-- Comments Modal -->
    <div class="modal fade" id="commentsModal" tabindex="-1" role="dialog" aria-labelledby="commentsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commentsModalLabel">Class comments</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">
                    <div id="commentsContent"></div>
                    <div class="d-flex mt-3">
                        <img src="{{ auth()->user()->profile_photo_url ?? 'default_profile_photo_url' }}" alt="user"
                            class="rounded-circle me-2" width="40 " height="40">
                        <input type="text" class="form-control modal-comment-input"
                            placeholder="Add class comment...">
                        <button type="button" class="btn btn-primary post-modal-comment-button"
                            style="margin-left: 10px;">
                            <i data-feather="send" class="feather-icon"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
        $(document).ready(function() {
            $('#announceInput').on('focus', function() {
                $('#announceBox').addClass('active');
            });

            $('#announceInput').on('blur', function() {
                if (!$(this).val()) {
                    $('#announceBox').removeClass('active');
                }
            });

            $('#postButton').on('click', function() {
                var formData = new FormData($('#announceForm')[0]);
                $.ajax({
                    url: "{{ route('announcements.store') }}",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.progress').show();
                        $('.progress-bar').width('0%').text('0%');
                    },
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function(e) {
                            if (e.lengthComputable) {
                                var percent = Math.round((e.loaded / e.total) * 100);
                                $('.progress-bar').width(percent + '%').text(percent +
                                    '%');
                            }
                        });
                        return xhr;
                    },
                    success: function(response) {
                        $('.progress').hide();
                        $('#announceInput').val('');
                        $('#fileInput').val('');
                        $('#photoInput').val('');
                        $('#videoInput').val('');
                        $('#announceBox').removeClass('active');
                        Swal.fire({
                            title: 'Success!',
                            text: response.success,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location
                            .reload(); // Reload page to show new announcement
                            }
                        });
                    },
                    error: function(response) {
                        $('.progress').hide();
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
            $('.post-comment-button').on('click', function() {
                var announcementId = $(this).data('announcement-id');
                var commentInput = $(this).siblings('.comment-input');
                var comment = commentInput.val();
                if (comment) {
                    $.ajax({
                        url: "{{ route('comments.store') }}",
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            announcement_id: announcementId,
                            content: comment
                        },
                        success: function(response) {
                            commentInput.val('');
                            alert('Comment posted successfully!');
                            location.reload(); // Reload page to show new comment
                        },
                        error: function(response) {
                            alert('An error occurred. Please try again.');
                        }
                    });
                }
            });

            $('.show-comments').on('click', function(event) {
                event.preventDefault();
                var announcementId = $(this).data('announcement-id');
                $.ajax({
                    url: "{{ route('comments.show', ':announcementId') }}".replace(
                        ':announcementId', announcementId),
                    type: 'GET',
                    success: function(response) {
                        $('#commentsContent').html(response);
                        $('#commentsModal').modal('show');

                        // Update modal post comment button data
                        $('.post-modal-comment-button').data('announcement-id', announcementId);
                    },
                    error: function(response) {
                        alert('An error occurred. Please try again.');
                    }
                });
            });

            $('.post-modal-comment-button').on('click', function() {
                var announcementId = $(this).data('announcement-id');
                var commentInput = $(this).siblings('.modal-comment-input');
                var comment = commentInput.val();
                if (comment) {
                    $.ajax({
                        url: "{{ route('comments.store') }}",
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            announcement_id: announcementId,
                            content: comment
                        },
                        success: function(response) {
                            commentInput.val('');
                            alert('Comment posted successfully!');
                            location.reload(); // Reload page to show new comment
                        },
                        error: function(response) {
                            alert('An error occurred. Please try again.');
                        }
                    });
                }
            });
        });

        function autoExpand(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
            var announceBox = document.getElementById('announceBox');
            if (textarea.scrollHeight > announceBox.clientHeight) {
                announceBox.classList.add('expanded');
            } else {
                announceBox.classList.remove('expanded');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var textarea = document.getElementById('announceInput');
            autoExpand(textarea);
        });

        document.getElementById('announceInput').addEventListener('click', function() {
            var announceBox = document.getElementById('announceBox');
            announceBox.classList.add('expanded');
        });
    </script>
@endsection
