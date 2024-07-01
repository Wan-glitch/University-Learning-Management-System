@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1>{{ $bulletin->title }}</h1>
            <p>{{ $bulletin->content }}</p>
            <p>Category: {{ $bulletin->category }}</p>
            @if($bulletin->faculty)
            <p>Faculty: {{ $bulletin->faculty->name }}</p>
            @endif
            @if($bulletin->attachments)
            <p>Attachments:</p>
            <ul>
                @foreach($bulletin->attachments as $attachment)
                <li><a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank">{{ $attachment->file_path }}</a></li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
</div>
@endsection
