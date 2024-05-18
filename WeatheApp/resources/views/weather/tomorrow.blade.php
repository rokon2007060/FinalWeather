@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Tomorrow's Forecast</h2>
    @if(isset($weather))
        <div class="weather-card text-center p-4">
            <h2>{{ $weather['name'] }}</h2>
            <div class="weather-info">
                <p><strong>Temperature:</strong> {{ $weather['temp']['day'] }} °C</p>
                <p><strong>Weather:</strong> {{ ucfirst($weather['weather'][0]['description']) }}</p>
                <p><strong>Humidity:</strong> {{ $weather['humidity'] }} %</p>
                <p><strong>Wind Speed:</strong> {{ $weather['wind_speed'] }} m/s</p>
            </div>
        </div>
    @elseif(isset($error))
        <div class="alert alert-danger text-center">
            <p>{{ $error }}</p>
        </div>
    @endif
</div>
@endsection
