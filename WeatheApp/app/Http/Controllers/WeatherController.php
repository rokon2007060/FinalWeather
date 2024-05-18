<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DateTime;

class WeatherController extends Controller
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = env('OPENWEATHERMAP_API_KEY');
    }

    public function index(Request $request)
    {
        return $this->getWeatherView($request, 'index');
    }

    public function hourly(Request $request)
    {
        return $this->getWeatherView($request, 'hourly');
    }


    public function tenDay(Request $request)
    {
        return $this->getEightDayWeather($request);
    }

    private function getEightDayWeather(Request $request)
    {
        $city = $request->query('city', 'Dhaka');
        $weatherData = $this->getWeatherData($city, 'forecast');

        if ($weatherData && isset($weatherData['list'])) {
            $eightDayForecast = [];
            $today = new DateTime();
            $endDate = (clone $today)->modify('+8 days');

            foreach ($weatherData['list'] as $day) {
                // Ensure 'dt_txt', 'main.temp' and 'weather[0].description' keys exist
                if (isset($day['dt_txt'], $day['main']['temp'], $day['weather'][0]['description'])) {
                    $date = new DateTime($day['dt_txt']);
                    if ($date <= $endDate) {
                        $eightDayForecast[$date->format('Y-m-d')] = [
                            'date' => $date->format('D, M d'),
                            'temperature' => $day['main']['temp'],
                            'description' => ucfirst($day['weather'][0]['description']),
                        ];
                    }
                }
            }

            return view('weather.ten-day', ['weather' => $eightDayForecast]);
        } else {
            return view('weather.ten-day', ['error' => 'City not found or data not available']);
        }
    }



    public function weekend(Request $request)
    {
        $city = $request->query('city', 'Dhaka');
        $weatherData = $this->getWeatherData($city, 'forecast');

        if ($weatherData && isset($weatherData['list'])) {
            $weekendForecast = [];
            foreach ($weatherData['list'] as $day) {
                // Check if the day falls on Saturday or Sunday (6 or 7)
                if (date('N', $day['dt']) >= 6) {
                    // Ensure 'main' and 'weather' keys exist before accessing 'temp' and 'description'
                    if (isset($day['main']['temp']) && isset($day['weather'][0]['description'])) {
                        $weekendForecast[] = [
                            'date' => date('D, M d', $day['dt']),
                            'temperature' => $day['main']['temp'],
                            'description' => ucfirst($day['weather'][0]['description']),
                        ];
                    }
                }
            }

            return view('weather.weekend', ['weather' => $weekendForecast]);
        } else {
            return view('weather.weekend', ['error' => 'City not found or data not available']);
        }
    }


    public function monthly(Request $request)
    {
        return $this->getWeatherView($request, 'monthly');
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
        return $this->getWeatherView($request, 'tomorrow');
    }

    public function nextWeek(Request $request)
    {
        return $this->getWeatherView($request, 'next-week');
    }

    private function getWeatherView(Request $request, $view)
    {
        $city = $request->query('city', 'Dhaka');
        $weatherData = $this->getWeatherData($city, $view);

        // Store recent searches in the session
        $recentSearches = session()->get('recentSearches', []);

        // Add current search to recent searches
        $currentSearch = [
            'city' => $city,
            'weather' => $weatherData // Store weather data along with the city
        ];

        // Add current search to recent searches
        array_unshift($recentSearches, $currentSearch);
        // Keep only the latest 5 searches
        $recentSearches = array_slice($recentSearches, 0, 5);

        session(['recentSearches' => $recentSearches]);

        if ($weatherData) {
            return view('weather.' . $view, ['weather' => $weatherData]);
        } else {
            return view('weather.' . $view, ['error' => 'City not found']);
        }
    }




    private function getWeatherData($city, $view)
    {
        $response = Http::get('https://api.openweathermap.org/data/2.5/' . $this->getEndpoint($view), [
            'q' => $city,
            'appid' => $this->apiKey,
            'units' => 'metric',
        ]);

        \Log::info($response->json());

        if ($response->successful()) {
            $weatherData = $response->json();
            // Add additional weather information
            if (isset($weatherData['main'])) {
                $weatherData['temperature'] = $weatherData['main']['temp'];
                $weatherData['humidity'] = $weatherData['main']['humidity'];
            }
            if (isset($weatherData['wind']) && isset($weatherData['wind']['speed'])) {
                $weatherData['wind_speed'] = $weatherData['wind']['speed'];
            } else {
                // Set wind speed to null if it's not available
                $weatherData['wind_speed'] = null;
            }
            return $weatherData;
        } else {
            return null;
        }
    }



    private function getEndpoint($view)
    {
        switch ($view) {
            case 'index':
                return 'weather';
            case 'hourly':
                return 'forecast';
            case 'ten-day':
                return 'forecast';
            case 'weekend':
                return 'forecast';
            case 'monthly':
                return 'forecast';
            case 'tomorrow':
                return 'forecast';
            case 'next-week':
                return 'forecast';
            default:
                return 'weather';
        }
    }
}
