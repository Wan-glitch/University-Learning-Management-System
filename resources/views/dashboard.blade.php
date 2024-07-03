
@extends('layout.app')
@section('content')
@if(Auth::check() && Auth::user()->role=='1')
    @include('admin.dashboard')

@else


    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tasks.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 col-md-12 order-1">
                <style>
                    /* Suggestions items */


                    .nav-tabs .nav-item {
                        flex: 1;
                        text-align: center;
                    }

                    .nav-tabs .nav-link {
                        border: none;
                        border-bottom: 3px solid transparent;
                    }

                    .nav-tabs .nav-link.active {
                        border-bottom-color: #3a3a3a;
                        color: #3a3a3a;
                        font-weight: bold;
                    }

                    .tab-content {
                        padding-top: 10px;
                    }

                    .item {
                        border-bottom: 1px solid #ddd;
                        padding: 15px 0;
                    }

                    .item:last-child {
                        border-bottom: none;
                    }

                    .title {
                        font-size: 18px;
                        font-weight: bold;
                        color: #3a3a3a;
                        margin: 0;
                    }

                    .date {
                        color: #888;
                        font-size: 14px;
                        margin-top: 5px;
                    }

                    .view-all {
                        text-align: center;
                        padding: 20px;
                        color: #3a3a3a;
                        text-decoration: none;
                        display: block;
                    }

                    .tasks-card .card-title {
                        font-size: 16px;
                        font-weight: bold;
                        color: #3a3a3a;
                        margin: 0;
                    }

                    .list-group-item a {
                        text-decoration: none;
                        color: #3a3a3a;
                        font-weight: bold;
                    }

                    .list-group-item .float-end {
                        color: #888;
                        font-size: 14px;
                    }
                </style>
                </head>
                <body>
                    <div class="row">
                        <div class="col-lg-9 col-md-8 col-12 mb-4">
                            <div class="card h-100">
                                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                                    <!-- Header content -->
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-end mb-3">
                                    @can('Create Bulletin')
                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#createBulletinModal">
                                            <span class="tf-icons bx bx-plus"></span>&nbsp; Announcement
                                        </button>
                                    @endcan


                                    </div>
                                    <ul class="nav nav-tabs nav-fill" role="tablist">
                                        <li class="nav-item">
                                            <button type="button" class="nav-link active" role="tab"
                                                data-bs-toggle="tab" data-bs-target="#bulletin" aria-controls="bulletin"
                                                aria-selected="true">
                                                Bulletin
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                data-bs-target="#faculty" aria-controls="faculty" aria-selected="false">
                                                Faculty
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                data-bs-target="#reminder" aria-controls="reminder" aria-selected="false">
                                                Reminder
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="bulletin" role="tabpanel">
                                            @foreach ($bulletins->where('category', 'Bulletin') as $bulletin)
                                                <div class="item mb-3">
                                                    <p class="title">{{ $bulletin->title }}</p>
                                                    <p class="date">{{ $bulletin->created_at->format('d M Y') }}</p>
                                                    <div class="actions">
                                                        @can('Edit Bulletin')
                                                            <button class="btn btn-sm btn-warning" onclick="loadEditBulletin({{ $bulletin }})">Edit</button>
                                                        @endcan
                                                        @can('Delete Bulletin')
                                                            <form action="{{ route('bulletins.destroy', $bulletin->id) }}" method="POST" class="d-inline-block">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                            </form>
                                                        @endcan
                                                    </div>
                                                </div>
                                            @endforeach
                                            <a href="#" class="view-all" data-category="Bulletin">~ View All ~</a>
                                        </div>
                                        <div class="tab-pane fade" id="faculty" role="tabpanel">
                                            @foreach ($bulletins->where('category', 'Faculty') as $bulletin)
                                                <div class="item mb-3">
                                                    <p class="title">{{ $bulletin->title }}</p>
                                                    <p class="date">{{ $bulletin->created_at->format('d M Y') }}</p>
                                                    <div class="actions">
                                                        @can('Edit Bulletin')
                                                            <button class="btn btn-sm btn-warning" onclick="loadEditBulletin({{ $bulletin }})">Edit</button>
                                                        @endcan
                                                        @can('Delete Bulletin')
                                                            <form action="{{ route('bulletins.destroy', $bulletin->id) }}" method="POST" class="d-inline-block">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                            </form>
                                                        @endcan
                                                    </div>
                                                </div>
                                            @endforeach
                                            <a href="#" class="view-all" data-category="Faculty">~ View All ~</a>
                                        </div>
                                        <div class="tab-pane fade" id="reminder" role="tabpanel">
                                            @foreach ($bulletins->where('category', 'Reminder')->filter(fn($b) => $b->recipients->contains(auth()->user())) as $bulletin)
                                                <div class="item mb-3">
                                                    <p class="title">{{ $bulletin->title }}</p>
                                                    <p class="date">{{ $bulletin->created_at->format('d M Y') }}</p>
                                                    <div class="actions">
                                                        @can('Edit Bulletin')
                                                            <button class="btn btn-sm btn-warning" onclick="loadEditBulletin({{ $bulletin }})">Edit</button>
                                                        @endcan
                                                        @can('Delete Bulletin')
                                                            <form action="{{ route('bulletins.destroy', $bulletin->id) }}" method="POST" class="d-inline-block">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                            </form>
                                                        @endcan
                                                    </div>
                                                </div>
                                            @endforeach
                                            <a href="#" class="view-all" data-category="Reminder">~ View All ~</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="tasks-custom">
                                <h3 style="border-bottom: 1px solid #dee2e6;">Tasks</h3>
                                @foreach($tasks as $courseName => $courseTasks)
                                    <div class="course-group" style="border-bottom: 1px solid #dee2e6;">
                                        <h5>{{ $courseName }}</h5>
                                        @foreach($courseTasks as $task)
                                            <div class="task-custom">
                                                <div>
                                                    <strong>{{ $task->title }}</strong><br>
                                                </div>
                                                <div>
                                                    @if(\Carbon\Carbon::parse($task->due_date)->isPast())
                                                        <span class="text-danger">{{ \Carbon\Carbon::parse($task->due_date)->format('d M, H:i') }}</span>
                                                    @else
                                                        <span>{{ \Carbon\Carbon::parse($task->due_date)->format('d M, H:i') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @include('bulletin.create_bulletin_modal')
                    @include('bulletin.edit_bulletin_modal')
                    @include('bulletin.view_modal')

                    <script>
                        $(document).ready(function() {
                            $('.view-all').on('click', function(e) {
                                e.preventDefault();
                                var category = $(this).data('category');
                                $.ajax({
                                    url: "{{ route('bulletins.filter') }}",
                                    type: "GET",
                                    data: { category: category },
                                    success: function(data) {
                                        $('#bulletin-list').html(data);
                                        $('#bulletinModal').modal('show');
                                    }
                                });
                            });

                            $('.close-btn').on('click', function() {
                                $('#bulletinModal').modal('hide');
                            });

                            $(window).on('click', function(event) {
                                if (event.target.id === 'bulletinModal') {
                                    $('#bulletinModal').modal('hide');
                                }
                            });
                        });
                    </script>
                    @endsection
@endif
