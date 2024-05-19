<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\NewsLike;
use App\Models\NewsComment;
use App\Models\WeatherNews;
use Illuminate\Support\Facades\Session;

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
            $today = new \DateTime();
            $endDate = (clone $today)->modify('+8 days');

            foreach ($weatherData['list'] as $day) {
                if (isset($day['dt_txt'], $day['main']['temp'], $day['weather'][0]['description'])) {
                    $date = new \DateTime($day['dt_txt']);
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
                if (date('N', $day['dt']) >= 6) {
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

    public function news(Request $request)
    {
        $apiKey = env('NEWS_API_KEY');
        $query = 'weather';
        $apiUrl = 'https://newsapi.org/v2/everything?q=' . urlencode($query) . '&apiKey=' . $apiKey;

        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $newsData = $response->json();
            return view('weather.news', ['news' => $newsData['articles']]);
        } else {
            return view('weather.news', ['error' => 'Failed to retrieve weather news']);
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

    public function tomorrow(Request $request)
    {
        return $this->getWeatherView($request, 'tomorrow');
    }

    public function nextWeek(Request $request)
    {
        return $this->getWeatherView($request, 'next-week');
    }

    // public function likeNews($id)
    // {
    //     $userId = Auth::id();
    //     $newsLike = NewsLike::firstOrCreate(['news_id' => $id, 'user_id' => $userId]);
    //     return back();
    // }

    // public function commentNews(Request $request, $id)
    // {
    //     $userId = Auth::id();
    //     $comment = new NewsComment();
    //     $comment->news_id = $id;
    //     $comment->user_id = $userId;
    //     $comment->comment = $request->input('comment');
    //     $comment->save();
    //     return back();
    // }


    public function index1()
    {
        $news = WeatherNews::all();
        return view('weather.index1', compact('news'));
    }

    // Method to show a specific news article
    public function show($id)
    {
        $article = WeatherNews::with(['comments.user', 'likes'])->findOrFail($id);
        return view('weather.show', compact('article'));
    }

    // Method to like a news article
    public function likeNews($id)
    {
        $article = WeatherNews::findOrFail($id);

        // Check if the user already liked this article
        $like = NewsLike::where('weather_news_id', $id)
                        ->where('user_id', Auth::id())
                        ->first();

        if (!$like) {
            NewsLike::create([
                'weather_news_id' => $id,
                'user_id' => Auth::id(),
            ]);
        }

        return back();
    }

    // Method to comment on a news article
    public function commentNews(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        $article = WeatherNews::findOrFail($id);

        $article->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->comment,
        ]);

        return back();
    }

    private function getWeatherView(Request $request, $view)
    {
        $city = $request->query('city', 'Dhaka');
        $weatherData = $this->getWeatherData($city, $view);

        if (Session::has('user')) {
        $recentSearches = session()->get('recentSearches', []);
        $currentSearch = [
            'city' => $city,
            'weather' => $weatherData
        ];

        array_unshift($recentSearches, $currentSearch);
        $recentSearches = array_slice($recentSearches, 0, 5);

        session(['recentSearches' => $recentSearches]);}

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

        if ($response->successful()) {
            $weatherData = $response->json();
            if (isset($weatherData['main'])) {
                $weatherData['temperature'] = $weatherData['main']['temp'];
                $weatherData['humidity'] = $weatherData['main']['humidity'];
            }
            if (isset($weatherData['wind']) && isset($weatherData['wind']['speed'])) {
                $weatherData['wind_speed'] = $weatherData['wind']['speed'];
            } else {
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

