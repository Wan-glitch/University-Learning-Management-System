@foreach ($bulletins as $bulletin)
    <div class="bulletin-item card mb-3" data-id="{{ $bulletin->id }}">
        <div class="card-body">
            <p class="title">{{ $bulletin->title }}</p>
            <p class="date">{{ $bulletin->created_at->format('d M Y') }}</p>
            <div class="actions">
                <button class="btn btn-sm btn-warning" onclick="loadEditBulletin({{ $bulletin }})">Edit</button>
                <form action="{{ route('bulletins.destroy', $bulletin->id) }}" method="POST" class="d-inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endforeach
