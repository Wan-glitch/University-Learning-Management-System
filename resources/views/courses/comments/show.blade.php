@foreach($comments as $comment)
    <div class="d-flex align-items-start mb-2">
        <img src="{{ $comment->user->profile_photo_url ?? 'default_profile_photo_url' }}" alt="user" class="rounded-circle me-2" width="40" height="40">
        <div>
            <p class="mb-0"><strong>{{ $comment->user->name }}</strong> <span class="text-muted">{{ $comment->created_at->format('M d, Y') }}</span></p>
            <p class="mb-0">{{ $comment->content }}</p>
        </div>
    </div>
@endforeach
