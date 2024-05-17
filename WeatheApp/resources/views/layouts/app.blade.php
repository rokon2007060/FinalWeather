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
            background: #f2f2f2;
            color: #333;
        }
        .navbar-custom {
            background-color: #005b96;
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
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
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
                    <a class="nav-link" href="/weather/video">Video</a>
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
            </ul>
            <form class="form-inline search-bar ml-lg-5" method="GET" action="/weather">
                <input class="form-control mr-sm-2" type="search" placeholder="Search City or Zip Code" aria-label="Search" name="city" required>
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
