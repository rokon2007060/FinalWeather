<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherNews extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'url'];

    public function likes()
    {
        return $this->hasMany(NewsLike::class);
    }

    public function comments()
    {
        return $this->hasMany(NewsComment::class);
    }
}
