<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <style>
        body {
            background: linear-gradient(to bottom, #83a4d4, #b6fbff);
            color: #333;
            font-family: 'Arial', sans-serif;
        }
        .navbar-custom {
            background-color: rgba(0, 91, 150, 0.8);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            position: relative;
        }
        .navbar-custom .navbar-nav .nav-link {
            color: #fff;
        }
        .navbar-custom .navbar-nav .nav-link:hover {
            color: #ddd;
        }
        .navbar-custom .navbar-brand {
            color: #fff;
        }
        .search-bar {
            width: 100%;
            max-width: 600px;
            margin: auto;
        }
        .weather-card {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .weather-info {
            font-size: 1.2em;
        }
        .weather-info p {
            margin: 10px 0;
        }
        .additional-info {
            margin-top: 20px;
        }
        .additional-info .card {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .recent-searches {
            margin-top: 20px;
        }
        .recent-searches .list-group-item {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }
        /* Cloud and Sun */
        .cloud-container {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            height: 150px;
            z-index: 0;
        }
        .cloud {
            position: absolute;
            background: #e0e0e0;
            border-radius: 50%;
            animation: moveClouds 20s linear infinite;
        }
        .cloud:before,
        .cloud:after {
            content: '';
            position: absolute;
            background: #e0e0e0;
            border-radius: 50%;
        }
        .cloud {
            width: 100px;
            height: 60px;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
        }
        .cloud:before {
            width: 60px;
            height: 60px;
            top: -30px;
            left: 10px;
        }
        .cloud:after {
            width: 80px;
            height: 80px;
            top: -40px;
            left: -30px;
        }
        .sun {
            position: absolute;
            width: 80px;
            height: 80px;
            background: #FFD700;
            border-radius: 50%;
            top: 50px;
            right: 20px;
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.5);
            animation: sunMovement 20s linear infinite;
        }
        @keyframes moveClouds {
            0% {
                left: -20%;
            }
            100% {
                left: 120%;
            }
        }
        @keyframes sunMovement {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-20px) scale(1.1);
            }
        }
        .cloud:nth-child(1) { animation-duration: 20s; }
        .cloud:nth-child(2) { animation-duration: 25s; top: 50px; left: 70%; }
        .cloud:nth-child(3) { animation-duration: 30s; top: 80px; left: 30%; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <a class="navbar-brand" href="#">The Weather Channel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/weather">Today</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/weather/hourly">Hourly</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/weather/10-day">10 Day</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/weather/weekend">Weekend</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/weather/monthly">Monthly</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/weather/radar">Radar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/weather/news">Weather News</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        More Forecasts
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="/weather/tomorrow">Tomorrow</a>
                        <a class="dropdown-item" href="/weather/next-week">Next Week</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="authDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @php
                            $user = session('user');
                        @endphp

                        @if($user && is_object($user))
                            {{ $user->name }}
                        @else
                            Account
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="authDropdown">
                        @if($user && is_object($user))
                            <a class="dropdown-item" href="/profile">Profile</a>
                            <a class="dropdown-item" href="/profile/liked-news">Liked News</a>
                            <a class="dropdown-item" href="/profile/comments">Comments</a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        @else
                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#loginModal">Login</button>
                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#registerModal">Register</button>
                        @endif
                    </div>
                </li>

            </ul>
            <form class="form-inline search-bar ml-lg-5" method="GET" action="/weather">
                <input class="form-control mr-sm-2" type="search" placeholder="Search City or Zip Code" aria-label="Search" name="city" required>
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </nav>

    <div class="container">
        @yield('content')

        <!-- Additional content like additional weather info and recent searches here -->

        <div class="additional-info">
            <!-- Additional weather information and cards -->
            <div class="card">
                <h5 class="card-title">Additional Weather Info</h5>
                <p class="card-text">Humidity: 60%</p>
                <p class="card-text">Visibility: 10 km</p>
                <p class="card-text">UV Index: 5</p>
            </div>
        </div>

        <div class="recent-searches">
            <h5>Recent Searches</h5>
            <ul class="list-group">
                <li class="list-group-item">New York, NY</li>
                <li class="list-group-item">Los Angeles, CA</li>
                <li class="list-group-item">Chicago, IL</li>
            </ul>
        </div>
    </div>

    <div class="cloud-container">
        <div class="cloud"></div>
        <div class="cloud"></div>
        <div class="cloud"></div>
    </div>
    <div class="sun"></div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
