




@extends('layout.app')

@section('content')
<div class="text-center">
    <h3>Scan this QR Code to register your attendance</h3>
    {!! $qrCode !!}
    <p>If you are unable to scan the QR Code, use this link to sign in:</p>
    <p><a href="{{ route('attendance.manual', ['course' => $course->id]) }}">{{ route('attendance.manual', ['course' => $course->id]) }}</a></p>
    @if (Carbon\Carbon::now()->gt(Carbon\Carbon::parse($qrData['expires_at'])))
        <p class="text-danger">This QR Code has expired.</p>
    @else
        <p>This QR Code is valid until {{ Carbon\Carbon::parse($qrData['expires_at'])->toDayDateTimeString() }}.</p>
    @endif
</div>
@endsection
