<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = env('OPENWEATHERMAP_API_KEY');
    }

    public function index(Request $request)
    {
        $city = $request->query('city', 'Dhaka');
        $weather = $this->getWeatherData($city);

        if ($weather) {
            return view('weather.index', ['weather' => $weather]);
        } else {
            return view('weather.index', ['error' => 'City not found']);
        }
    }

    public function hourly(Request $request)
    {
        $city = $request->query('city', 'Dhaka');
        $weather = $this->getHourlyWeatherData($city);

        if ($weather) {
            return view('weather.hourly', ['weather' => $weather]);
        } else {
            return view('weather.hourly', ['error' => 'City not found']);
        }
    }

    public function tenDay(Request $request)
    {
        $city = $request->query('city', 'Dhaka');
        $weather = $this->getTenDayWeatherData($city);

        if ($weather) {
            return view('weather.ten-day', ['weather' => $weather]);
        } else {
            return view('weather.ten-day', ['error' => 'City not found']);
        }
    }

    public function weekend(Request $request)
    {
        $city = $request->query('city', 'Dhaka');
        $weather = $this->getWeekendWeatherData($city);

        if ($weather) {
            return view('weather.weekend', ['weather' => $weather]);
        } else {
            return view('weather.weekend', ['error' => 'City not found']);
        }
    }

    public function monthly(Request $request)
    {
        $city = $request->query('city', 'Dhaka');
        $weather = $this->getMonthlyWeatherData($city);

        if ($weather) {
            return view('weather.monthly', ['weather' => $weather]);
        } else {
            return view('weather.monthly', ['error' => 'City not found']);
        }
    }

    public function radar()
    {
        return view('weather.radar');
    }

    public function video()
    {
        return view('weather.video');
    }

    public function tomorrow(Request $request)
    {
        $city = $request->query('city', 'Dhaka');
        $weather = $this->getTomorrowWeatherData($city);

        if ($weather) {
            return view('weather.tomorrow', ['weather' => $weather]);
        } else {
            return view('weather.tomorrow', ['error' => 'City not found']);
        }
    }

    public function nextWeek(Request $request)
    {
        $city = $request->query('city', 'Dhaka');
        $weather = $this->getNextWeekWeatherData($city);

        if ($weather) {
            return view('weather.next-week', ['weather' => $weather]);
        } else {
            return view('weather.next-week', ['error' => 'City not found']);
        }
    }

    private function getWeatherData($city)
    {
        // Fetch current weather data logic
    }

    private function getHourlyWeatherData($city)
    {
        // Fetch hourly weather data logic
    }

    private function getTenDayWeatherData($city)
    {
        // Fetch 10-day weather data logic
    }

    private function getWeekendWeatherData($city)
    {
        // Fetch weekend weather data logic
    }

    private function getMonthlyWeatherData($city)
    {
        // Fetch monthly weather data logic
    }

    private function getTomorrowWeatherData($city)
    {
        // Fetch tomorrow's weather data logic
    }

    private function getNextWeekWeatherData($city)
    {
        // Fetch next week's weather data logic
    }
}
