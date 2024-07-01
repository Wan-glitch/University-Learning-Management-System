@component('mail::message')
# Reminder: {{ $bulletin->title }}

{!! $bulletin->content !!}

@if($bulletin->attachments->count() > 0)
    @component('mail::panel')
    **Attachments:**
    <ul>
        @foreach ($bulletin->attachments as $attachment)
            <li><a href="{{ asset('storage/' . $attachment->file_path) }}">{{ $attachment->file_path }}</a></li>
        @endforeach
    </ul>
    @endcomponent
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
