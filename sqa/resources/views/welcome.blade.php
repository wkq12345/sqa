<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | My SQA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8fafc;
            font-family: 'Nunito', sans-serif;
        }
        .navbar {
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .content {
            height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">Education</a>
            <div class="d-flex ms-auto">
                @if (Route::has('login'))
                    <div class="d-flex">
                        @auth
                            <a href="staff.dashboard" class="btn btn-primary me-2">Home</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <div class="content">
        <div>
            <h1 class="display-4 fw-bold">Welcome to SQA website</h1>
            <p class="lead text-muted">Learning Platform!</p>
            <a href="{{ route('login') }}" class="btn btn-lg btn-primary mt-3">Get Started</a>
        </div>
    </div>
</body>
</html>
