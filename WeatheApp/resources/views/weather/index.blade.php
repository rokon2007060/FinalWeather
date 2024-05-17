<!DOCTYPE html>
<html>
<head>
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
                    <a class="nav-link" href="#">Today</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Hourly</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">10 Day</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Weekend</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Monthly</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Radar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Video</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        More Forecasts
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Tomorrow</a>
                        <a class="dropdown-item" href="#">Next Week</a>
                    </div>
                </li>
            </ul>
            <form class="form-inline search-bar ml-lg-5" method="GET" action="/weather">
                <input class="form-control mr-sm-2" type="search" placeholder="Search City or Zip Code" aria-label="Search" name="city" required>
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="mt-5">
            @if(isset($weather))
                <div class="weather-card text-center p-4">
                    <h2>{{ $weather['name'] }}</h2>
                    <div class="weather-info">
                        <p><strong>Temperature:</strong> {{ $weather['main']['temp'] }} °C</p>
                        <p><strong>Weather:</strong> {{ ucfirst($weather['weather'][0]['description']) }}</p>
                        <p><strong>Humidity:</strong> {{ $weather['main']['humidity'] }} %</p>
                        <p><strong>Wind Speed:</strong> {{ $weather['wind']['speed'] }} m/s</p>
                    </div>
                </div>
                <div class="additional-info">
                    <div class="card">
                        <h5>Additional Information</h5>
                        <p><strong>Pressure:</strong> {{ $weather['main']['pressure'] }} hPa</p>
                        <p><strong>Visibility:</strong> {{ $weather['visibility'] / 1000 }} km</p>
                        <p><strong>Cloudiness:</strong> {{ $weather['clouds']['all'] }} %</p>
                    </div>
                    <div class="card">
                        <h5>Sunrise & Sunset</h5>
                        <p><strong>Sunrise:</strong> {{ date('H:i:s', $weather['sys']['sunrise']) }} UTC</p>
                        <p><strong>Sunset:</strong> {{ date('H:i:s', $weather['sys']['sunset']) }} UTC</p>
                    </div>
                </div>
            @elseif(isset($error))
                <div class="alert alert-danger text-center">
                    <p>{{ $error }}</p>
                </div>
            @endif
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
