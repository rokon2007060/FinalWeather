<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect('/weather');
});

Route::get('/weather', [WeatherController::class, 'index']);
Route::get('/weather/hourly', [WeatherController::class, 'hourly']);
Route::get('/weather/10-day', [WeatherController::class, 'tenDay']);
Route::get('/weather/weekend', [WeatherController::class, 'weekend']);
Route::get('/weather/monthly', [WeatherController::class, 'monthly']);
Route::get('/weather/radar', [WeatherController::class, 'radar']);
Route::get('/weather/video', [WeatherController::class, 'video']);
Route::get('/weather/tomorrow', [WeatherController::class, 'tomorrow']);
Route::get('/weather/next-week', [WeatherController::class, 'nextWeek']);


Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
