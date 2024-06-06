@extends('layout.app')

@section('content')
<!-- Content -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style>
    .card-custom {
        margin-bottom: 20px;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
    }
    .card-custom img {
        width: 50%; /* Adjust the width as needed */
        height: 50%; /* Adjust the height as needed */
        object-fit: cover;
        margin: 0 auto 20px; /* Center the image and add bottom margin */
    }
    .tasks-custom {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }
    .tasks-custom h3 {
        font-size: 18px;
        margin-bottom: 20px;
    }
    .task-custom {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    @media (max-width: 768px) {
        .card-custom {
            margin-left: auto;
            margin-right: auto;
        }
        .tasks-custom {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .tasks-custom {
            width: 100%;
            margin-top: 20px;
        }
    }
</style>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-5">
            <!-- Card 1 -->
            <div class="col-md-6 col-lg-3 mb-3">
                <a href="{{ route('courses.programming') }}" class="card h-100 card-custom">
                    <img class="card-img-top" src="{{asset('assets/img/elements/2.jpg')}}" alt="Card image cap" />
                    <div class="card-body">
                        <h5 class="card-title">Programming Fundamentals</h5>
                        <p class="card-text">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.
                        </p>
                        <div class="bell">🔔</div>
                    </div>
                </a>
            </div>
            <!-- Card 2 -->
            <div class="col-md-6 col-lg-3 mb-3">
                <a href="{{ route('courses.web-development') }}" class="card h-100 card-custom">
                    <img class="card-img-top" src="{{asset('assets/img/elements/2.jpg')}}" alt="Card image cap" />
                    <div class="card-body">
                        <h5 class="card-title">Web Development Application</h5>
                        <p class="card-text">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.
                        </p>
                        <div class="bell">🔔</div>
                    </div>
                </a>
            </div>
            <!-- Card 3 -->
            <div class="col-md-6 col-lg-3 mb-3">
                <a href="{{ route('courses.machine-learning') }}" class="card h-100 card-custom">
                    <img class="card-img-top" src="{{asset('assets/img/elements/2.jpg')}}" alt="Card image cap" />
                    <div class="card-body">
                        <h5 class="card-title">Machine Learning</h5>
                        <p class="card-text">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.
                        </p>
                        <div class="bell">🔔</div>
                    </div>
                </a>
            </div>
            <!-- Tasks Section -->
            <div class="col-lg-3 col-md-6 col-12">
                <div class="tasks-custom h-100">
                    <h3>Tasks</h3>
                    <div class="task-custom">
                        <span>Assignment 1</span>
                        <span>25 Dec, 23:59</span>
                    </div>
                    <div class="task-custom">
                        <span>Assignment 2</span>
                        <span>30 Dec, 23:59</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
