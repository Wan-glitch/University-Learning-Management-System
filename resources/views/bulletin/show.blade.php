{{-- <div class="card-body">
    <h2 class="card-title">{{ $bulletin->title }}</h2>
    <p class="card-text">Posted by {{ $bulletin->user->name }}</p>
    <p class="card-text">{{ $bulletin->created_at->format('d M Y') }}</p>

    <div class="bulletin-content">
        <?php
            // Clean up bulletin content
            $cleanedContent = cleanBulletinContent($bulletin->content);
        ?>
        {!! $cleanedContent !!}
    </div>

    <div class="attachments">
        <ul>
            @foreach($bulletin->files as $file)
                <li><a href="{{ asset('storage/' . $file->file_path) }}">{{ $file->file_path }}</a></li>
            @endforeach
        </ul>
    </div>
</div>

@php
function cleanBulletinContent($content) {
    // Remove <p>&nbsp;</p> from the content
    $cleanedContent = preg_replace('/<p>&nbsp;<\/p>/', '', $content);
    return $cleanedContent;
}
@endphp


 --}}
 <div class="card-body">
    <h2 class="card-title">{{ $bulletin->title }}</h2>
    <p class="card-text">Posted by {{ $bulletin->user->name }}</p>
    <p class="card-text">{{ $bulletin->created_at->format('d M Y') }}</p>

    <div class="bulletin-content">
        <?php
            // Clean up bulletin content
            $cleanedContent = cleanBulletinContent($bulletin->content);
        ?>
        {!! $cleanedContent !!}
    </div>

    <div class="attachments">
        <h4>Attachments:</h4>
        <ul class="list-unstyled">
            @foreach($bulletin->files as $file)
                <li>
                    @if (in_array($file->extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp'])) <!-- Check for image files -->
                        <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                            <img src="{{ asset('storage/' . $file->file_path) }}" alt="{{ $file->file_name }}" class="img-thumbnail" style="max-width: 150px;">
                        </a>
                    @elseif (in_array($file->extension, ['pdf'])) <!-- Check for PDF files -->
                        <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                            <img src="{{ asset('images/pdf-icon.png') }}" alt="PDF Icon" class="img-thumbnail" style="max-width: 150px;">
                        </a>
                    @else <!-- Display generic file icon for other file types -->
                        <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                            <img src="{{ asset('images/file-icon.png') }}" alt="File Icon" class="img-thumbnail" style="max-width: 150px;">
                        </a>
                    @endif
                    <p>{{ $file->file_name }}</p>
                </li>
            @endforeach
        </ul>
    </div>
</div>

@php
function cleanBulletinContent($content) {
    // Remove <p>&nbsp;</p> from the content
    $cleanedContent = preg_replace('/<p>&nbsp;<\/p>/', '', $content);
    return $cleanedContent;
}
@endphp
