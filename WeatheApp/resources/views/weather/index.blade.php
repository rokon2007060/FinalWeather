@extends('layouts.app')

@section('content')
<div class="container mt-5">
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
@endsection
