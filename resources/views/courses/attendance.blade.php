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
                        <h4 class="card-title">Generated QR Codes</h4>
                        <button class="btn btn-primary float-right" data-toggle="modal" data-target="#attendanceModal">Generate Attendance</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Expires At</th>
                                        <th>Number of Attendees</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($qrCodes->isEmpty())
                                    <tr>
                                        <td colspan="3" class="text-center">No QR codes generated</td>
                                    </tr>
                                    @else
                                    @foreach($qrCodes as $qrCode)
                                    <tr class="clickable-row" data-href="{{ route('attendance.details', ['course' => $course->id, 'qrCode' => $qrCode->id]) }}">
                                        <td>{{ $qrCode->generated_at }}</td>
                                        <td>{{ $qrCode->expires_at }}</td>
                                        <td>{{ $qrCode->attendances->count() }}</td>
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

<!-- Attendance Generation Modal -->
<div class="modal fade" id="attendanceModal" tabindex="-1" role="dialog" aria-labelledby="attendanceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="attendanceModalLabel">Generate Attendance QR Code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="qrForm">
                    <div class="form-group">
                        <label for="date">Date of Class:</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ now()->toDateString() }}" required>
                    </div>
                    <div class="form-group">
                        <label for="time">Time of Class:</label>
                        <input type="time" class="form-control" id="time" name="time" value="{{ now()->format('H:i') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="duration">QR Code Active Duration (minutes):</label>
                        <input type="number" class="form-control" id="duration" name="duration" placeholder="Enter duration in minutes" value="60" required>
                    </div>
                </form>
                <div id="qrCodeContainer" class="text-center mt-4" style="display: none;">
                    <h5>Scan this QR Code to register your attendance</h5>
                    <img id="qrCodeImage" src="" alt="QR Code">
                    <p class="mt-2">Expires at: <span id="qrExpiresAt"></span></p>
                    <p>Or use the manual attendance link:</p>
                    <p><a href="{{ route('manual-sign-in', ['course' => $course->id]) }}" target="_blank">Manual Attendance</a></p>
                </div>
            </div>
            <input type="hidden" id="course_id" value="{{ $course->id }}">
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="startAttendance()">Start Session</button>
            </div>
        </div>
    </div>
</div>

<script>
    function startAttendance() {
        var formData = {
            'date': $('#date').val(),
            'time': $('#time').val(),
            'duration': $('#duration').val(),
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'course_id': $('#course_id').val()
        };

        $.ajax({
            url: "{{ route('activate-qr', ['course' => $course->id]) }}",
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#qrCodeContainer').show();
                    $('#qrCodeImage').attr('src', 'data:image/png;base64,' + response.qrCode);
                    $('#qrExpiresAt').text(response.expires_at);
                } else {
                    alert('Error: ' + response.error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
            }
        });
    }

    $(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });
</script>

@endsection
