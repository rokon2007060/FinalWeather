@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $user->name }}'s Profile</h1>
    <p>Email: {{ $user->email }}</p>

    <h2>Liked News</h2>
    @if ($likedNews->isEmpty())
        <p>You haven't liked any news articles yet.</p>
    @else
        <ul>
            @foreach ($likedNews as $like)
                <li>
                    <a href="{{ $like->news->url }}" target="_blank">{{ $like->news->title }}</a>
                    <p>{{ $like->news->description }}</p>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
