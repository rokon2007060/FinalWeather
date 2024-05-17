<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function index(Request $request)
    {
        $city = $request->input('city', 'London'); // Default city
        $apiKey = env('OPENWEATHERMAP_API_KEY');

        $response = Http::get("http://api.openweathermap.org/data/2.5/weather", [
            'q' => $city,
            'appid' => $apiKey,
            'units' => 'metric'
        ]);

        if ($response->successful()) {
            $weatherData = $response->json();
            return view('weather.index', ['weather' => $weatherData]);
        } else {
            return view('weather.index', ['error' => 'Could not retrieve weather data']);
        }
    }
}
