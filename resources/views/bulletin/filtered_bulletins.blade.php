@foreach ($bulletins as $bulletin)
    <div class="card bulletin-card bulletin-item" data-id="{{ $bulletin->id }}">
        <div class="card-body">
            <div class="bulletin-header">
                <h5 class="card-title">{{ $bulletin->title }}</h5>
                <small class="card-text">by {{ $bulletin->user->name }}</small><br />
                <small class="card-text">{{ $bulletin->created_at->format('d M Y') }}</small>
            </div>
            <div class="bulletin-actions">
                <button class="btn btn-primary update-btn">Update</button>
                <button class="btn btn-danger delete-btn">Delete</button>
            </div>
        </div>
    </div>
@endforeach
