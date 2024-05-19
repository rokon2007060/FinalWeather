@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $article->title }}</h1>
    <p>{{ $article->description }}</p>

    <a href="{{ $article->url }}" target="_blank" class="btn btn-primary">Original Source</a>

    @auth
        <form action="{{ route('news.like', $article->id) }}" method="POST" class="mt-2">
            @csrf
            <button type="submit" class="btn btn-outline-primary">Like</button>
        </form>

        <form action="{{ route('news.comment', $article->id) }}" method="POST" class="mt-2">
            @csrf
            <textarea name="comment" class="form-control" rows="2" placeholder="Add a comment"></textarea>
            <button type="submit" class="btn btn-outline-secondary mt-2">Comment</button>
        </form>
    @endauth

    <h3>Comments</h3>
    @foreach ($article->comments as $comment)
        <div class="card mt-3">
            <div class="card-body">
                <p>{{ $comment->content }}</p>
                <small>By {{ $comment->user->name }} on {{ $comment->created_at }}</small>
            </div>
        </div>
    @endforeach
</div>
@endsection
