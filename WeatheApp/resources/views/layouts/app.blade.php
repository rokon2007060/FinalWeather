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
            /* overflow: hidden; */
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
            font-size: 40px;
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
                {{-- <li class="nav-item">
                    <a class="nav-link" href="/weather/monthly">Monthly</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/weather/radar">Radar</a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" href="/weather/news">Weather News</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        More Forecasts
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        {{-- <a class="dropdown-item" href="/weather/tomorrow">Tomorrow</a>
                        <a class="dropdown-item" href="/weather/next-week">Next Week</a> --}}
                    </div>
                </li>


            </ul>
            <form class="form-inline search-bar ml-lg-5" method="GET" action="/weather">
                <input class="form-control mr-sm-2" type="search" placeholder="Search City or Zip Code" aria-label="Search" name="city" required>
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
            </form>

            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="authDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle fa-lg"></i>
                        <span class="ml-2">@if(Session::has('user')) {{-- {{ Session::get('user')->name }} --}} @else Account @endif</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="authDropdown">
                        @if(Session::has('user'))
                            {{-- <a class="dropdown-item" href="/profile">Profile</a> --}}
                            <span class="ml-2">{{ Session::get('user')->name }} - {{ Session::get('user')->email }}</span>
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
        </div>
    </nav>

    <div class="container">
        @yield('content')

        <!-- Recent Searches Section -->
        <div class="recent-searches">
            <h5>Your Recent Searches</h5>
            <ul class="list-group">
                @foreach(session('recentSearches', []) as $search)
                    @if(is_array($search))
                        <li class="list-group-item">
                            <strong>City:</strong> {{ $search['city'] }}
                            @if(isset($search['weather']))
                                <span class="badge badge-primary">
                                    @if(isset($search['weather']['temperature']))
                                        Temperature: {{ $search['weather']['temperature'] }}°C,
                                    @else
                                        <span class="badge badge-warning">No temperature data available</span>
                                    @endif

                                    @if(isset($search['weather']['humidity']))
                                        Humidity: {{ $search['weather']['humidity'] }}%,
                                    @else
                                        <span class="badge badge-warning">No humidity data available</span>
                                    @endif

                                    @if(isset($search['weather']['wind-speed']))
                                        Wind Speed: {{ $search['weather']['wind-speed'] }} m/s
                                    @else
                                        <span class="badge badge-warning">No wind speed data available</span>
                                    @endif
                                </span>
                            @else
                                <span class="badge badge-warning">No weather data available</span>
                            @endif
                        </li>
                    @else
                        <li class="list-group-item">Invalid search data</li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>


    <div class="cloud-container">
        <div class="sun"></div>
        <div class="cloud"></div>
        <div class="cloud"></div>
        <div class="cloud"></div>
    </div>

    <!-- Modals -->
    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Register</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">E-Mail Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="password-confirm">Confirm Password</label>
                            <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">E-Mail Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Remember Me</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script>
        $(document).ready(function(){
            $(".read-more-btn").click(function(e){
                e.preventDefault();
                var url = $(this).data("url");
                $(this).parent().append('<iframe src="' + url + '" width="100%" height="400px"></iframe>');
                $(this).remove();
            });
        });
    </script>
</body>
</html>
