@extends('layout.app')

@section('content')
<!-- Content -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style>
    .sidebar {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
        height: 100%;
    }
    .sidebar a {
        display: block;
        padding: 10px 15px;
        margin-bottom: 10px;
        color: #333;
        text-decoration: none;
        border-radius: 5px;
    }
    .sidebar a:hover, .sidebar a.active {
        background-color: #f1f1f1;
    }
    .main-content {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
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
    .announcement {
        border: 1px solid #e1e1e1;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }
    .announcement .header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .announcement .header img {
        border-radius: 50%;
        width: 40px;
        height: 40px;
        margin-right: 10px;
    }
    .announcement .header .info {
        display: flex;
        align-items: center;
    }
    .announcement .header .date {
        font-size: 12px;
        color: #999;
    }
    .announcement .content {
        margin-bottom: 10px;
    }
    .announcement .comments {
        border-top: 1px solid #e1e1e1;
        padding-top: 10px;
    }
    .announcement .comments img {
        border-radius: 50%;
        width: 30px;
        height: 30px;
        margin-right: 10px;
    }
    .announcement .comments input {
        width: 100%;
        border: none;
        outline: none;
        padding: 10px;
    }
    .announce-box {
        display: flex;
        align-items: center;
        background-color: white;
        border-radius: 24px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 10px 20px;
        margin-bottom: 20px;
    }
    .announce-box img {
        border-radius: 50%;
        width: 40px;
        height: 40px;
        margin-right: 10px;
    }
    .announce-box input {
        border: none;
        outline: none;
        width: 100%;
        padding: 10px;
        font-size: 16px;
    }
</style>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-2 mb-4">
                <div class="sidebar">
                    <a href="#" class="active">Announcements</a>
                    <a href="#">Teaching Plan</a>
                    <a href="#">Modules</a>
                    <a href="#">Lecturer's Info</a>
                    <a href="#">Assignments</a>
                    <a href="#">Attendance</a>
                    <a href="#">Students</a>
                </div>
            </div>
            <div class="col-lg-7 mb-4">
                <div class="announce-box">
                    <img src="https://via.placeholder.com/40" alt="User">
                    <input type="text" placeholder="Announce something to your class">
                </div>
                <div class="main-content">
                    <div class="announcement">
                        <div class="header">
                            <div class="info">
                                <img src="https://via.placeholder.com/40" alt="User">
                                <div>
                                    <h6>John Smith</h6>
                                    <div class="date">10 January</div>
                                </div>
                            </div>
                        </div>
                        <div class="content">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </div>
                        <div class="comments">
                            <div class="info">
                                <img src="https://via.placeholder.com/30" alt="User">
                                <input type="text" placeholder="Write a comment...">
                            </div>
                        </div>
                    </div>
                    <div class="announcement">
                        <div class="header">
                            <div class="info">
                                <img src="https://via.placeholder.com/40" alt="User">
                                <div>
                                    <h6>John Smith</h6>
                                    <div class="date">8 January</div>
                                </div>
                            </div>
                        </div>
                        <div class="content">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </div>
                        <div class="comments">
                            <div class="info">
                                <img src="https://via.placeholder.com/30" alt="User">
                                <input type="text" placeholder="Write a comment...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
