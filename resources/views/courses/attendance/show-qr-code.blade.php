@extends('layout.app')

@section('content')
<div class="text-center">
    <h1>QR Code for Manual Attendance</h1>
    <div>
        {!! $qrCode->code !!}
    </div>
    <p>Expires at: {{ $qrCode->expires_at }}</p>
</div>

@endsection
