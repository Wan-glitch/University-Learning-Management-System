@extends('layout.app')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 col-md-12 order-1">

                <style>

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
                    {{-- <div class="container my-5"> --}}
                    <div class="row">
                        <div class="col-lg-9 col-md-8 col-12 mb-4">
                            <div class="card h-100">
                                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                                    <!-- Header content -->
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-end mb-3">
                                        <button class="btn btn-primary" id="createEventBtn" onclick="showModal()">
                                            <span class="tf-icons bx bx-plus"></span>&nbsp; Announcement
                                        </button>
                                        @include('announcement.create_announcement_modal')
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
                                            <div class="item">
                                                <p class="title">LOST &amp; FOUND ITEMS</p>
                                                <p class="date">2 Feb 2024</p>
                                            </div>
                                            <div class="item">
                                                <p class="title">Games Development Competition by Apple</p>
                                                <p class="date">29 Jan 2024</p>
                                            </div>
                                            <a href="#" class="view-all">~ View All ~</a>
                                        </div>
                                        <div class="tab-pane fade" id="faculty" role="tabpanel">
                                            <!-- Faculty content goes here -->
                                        </div>
                                        <div class="tab-pane fade" id="reminder" role="tabpanel">
                                            <!-- Reminder content goes here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('include.tasklist')


                    </div>

                    {{-- </div> --}}
                    <!-- / Content -->

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">SB12 MAINTENANCE</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis consequat auctor ipsum,
                                        ut commodo
                                        purus scelerisque molestie. Donec vestibulum felis quis sem convallis, quis
                                        efficitur sapien
                                        vestibulum. Vivamus fermentum dolor metus, sed condimentum quam sollicitudin a. Nam
                                        suscipit
                                        nunc id ligula convallis, vel lacinia nisi tempor. Nam bibendum volutpat ante non
                                        auctor.
                                        Vivamus ultricies neque id urna gravida, sed facilisis dolor ultrices. Vestibulum id
                                        odio
                                        aliquet, venenatis eros id, rutrum lacus. Etiam scelerisque sagittis suscipit.</p>
                                    <p>Donec condimentum in erat vel semper. Nullam facilisis vel diam in aliquet. Praesent
                                        varius
                                        viverra odio quis sagittis. Nunc et metus at ligula dignissim porta vitae in lorem.
                                        Praesent ac
                                        elementum metus. Integer nec convallis quam, nec malesuada urna. Vestibulum molestie
                                        et neque
                                        nec sodales. Phasellus ut posuere arcu. Duis ligula metus, accumsan ac sem
                                        hendrerit, porta
                                        fringilla mauris. Phasellus id ante fringilla, congue lorem ut, faucibus magna. Nunc
                                        placerat,
                                        sem eget semper dictum, urna mi sodales nunc, vel fringilla nunc mauris sit amet
                                        velit. </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endsection
                <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
                <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                <script>

                    function toggleTab(e) {
                        var hrefVal = $(e).attr('href');
                        $('.nav-tabs li').removeClass('active');
                        $('.nav-tabs li[data-active="' + hrefVal + '"]').addClass('active');
                    }

                    function showModal() {
                        $('#createAnnouncementModal').modal('show');
                    }

                    $(document).ready(function() {
                        // Initialize Tagify
                        var userTagsInput = document.getElementById('userTags');
                        var tagify = new Tagify(userTagsInput, {
                            enforceWhitelist: true,
                            whitelist: [], // You can populate whitelist dynamically if needed
                            dropdown: {
                                maxItems: 5,
                                enabled: 0,
                                closeOnSelect: false
                            }
                        });

                        // Show user selection if Reminder is chosen
                        $("#announcementCategory").change(function() {
                            if ($(this).val() === 'Reminder') {
                                $("#userSelection").show();
                                // You can add logic here to populate user selection options
                            } else {
                                $("#userSelection").hide();
                            }
                        });

                        // Form submission handling
                        $("#announcementForm").submit(function(e) {
                            e.preventDefault(); // Prevent default form submission

                            // Get form values
                            var title = $("#announcementTitle").val();
                            var content = $("#announcementContent").val();
                            var category = $("#announcementCategory").val();
                            var users = tagify.value.map(tag => tag.value); // Get selected users

                            // You can send this data to your backend via AJAX
                            console.log("Title: " + title);
                            console.log("Content: " + content);
                            console.log("Category: " + category);
                            console.log("Users: " + users);

                            // Close modal
                            $("#createAnnouncementModal").modal('hide');

                            // You can add AJAX call here to send data to the server
                        });

                    });
                </script>
