<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NewsLike;

class ProfileController extends Controller
{
    public function show()
    {
        // Retrieve the authenticated user's profile data
        $user = Auth::user();
        // Retrieve the news liked by the user
        $likedNews = NewsLike::where('user_id', $user->id)->with('news')->get();

        return view('profile.show', ['user' => $user, 'likedNews' => $likedNews]);
    }
}

