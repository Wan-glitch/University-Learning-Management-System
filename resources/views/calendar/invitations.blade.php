@extends('layout.app')

@section('content')
<div class="container">
    <h2>Your Event Invitations</h2>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        @foreach($invitations as $invitation)
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $invitation->event->title }}</h5>
                        <p class="card-text">Date: {{ $invitation->event->date }}</p>
                        <p class="card-text">Time: {{ $invitation->event->time }}</p>
                        <p class="card-text">Status: {{ ucfirst($invitation->status) }}</p>
                        @if($invitation->status == 'pending')
                            <form action="{{ route('calendar.acceptInvitation', $invitation->event->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success">Accept</button>
                            </form>
                            <form action="{{ route('calendar.declineInvitation', $invitation->event->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger">Decline</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
