@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Weather News</h1>

    @if (Auth::check())
        <p>User is authenticated</p>
    @else
        <p>User is not authenticated</p>
    @endif

    @if (isset($news) && count($news) > 0)
        @foreach ($news as $article)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $article->title }}</h5>
                    <p class="card-text">{{ $article->description }}</p>
                    <a href="{{ route('news.show', $article->id) }}" class="btn btn-primary">Read more</a>

                    @if (session()->has('user'))
                        <form action="{{ route('news.like', $article->id) }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary">Like</button>
                        </form>

                        <form action="{{ route('news.comment', $article->id) }}" method="POST" class="mt-2">
                            @csrf
                            <textarea name="comment" class="form-control" rows="2" placeholder="Add a comment"></textarea>
                            <button type="submit" class="btn btn-outline-secondary mt-2">Comment</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <p>No news articles found.</p>
    @endif
</div>
@endsection
