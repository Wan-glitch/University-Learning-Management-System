<!-- resources/views/main.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Portal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #e0e0e0;
        }
        .top-bar {
            padding: 10px 0;
            margin-bottom: 20px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .top-bar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .top-bar .nav {
            background-color: white;
            padding: 10px 20px;
            border-radius: 25px;
            box-shadow: 0px 2px 15px rgba(0,0,0,0.1);
            margin-left: auto;
        }
        .top-bar .nav a {
            color: #000;
            margin: 0 15px;
            font-weight: bold;
        }
        .slideshow {
            margin-top: 20px;
        }
        .login-box {
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 2px 4px rgba(0,0,0,0.1);
        }
        .login-box form {
            margin: 0;
        }
        .login-box .form-control {
            margin-bottom: 10px;
        }
        .login-box button {
            width: 100%;
        }
        @media (max-width: 767px) {
            .top-bar {
                flex-direction: column;
            }
            .top-bar .nav {
                margin-left: 0;
                margin-top: 10px;
                padding: 5px 10px;
            }
            .top-bar .nav a {
                margin: 0 10px;
            }
            .login-box {
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
    @include('layout.login-navbar')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div id="slideshow" class="carousel slide slideshow" data-ride="carousel">
                    <div class="carousel-inner" style="border-radius: 10px">
                        <div class="carousel-item active">
                            <img src="https://via.placeholder.com/800x400.png?text=Sample+Slideshow+Image" class="d-block w-100" alt="Slideshow Image">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @include('auth.login')
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
