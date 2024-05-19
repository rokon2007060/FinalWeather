@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Weather News</h1>

    @if (isset($news) && count($news) > 0)
        @foreach ($news as $article)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $article['title'] }}</h5>
                    <p class="card-text">{{ $article['description'] }}</p>
                    <a href="{{ $article['url'] }}" target="_blank" class="btn btn-primary">Read More</a>
                    {{-- <button class="btn btn-primary read-more" data-news-url="{{ $article['url'] }}">Read More</button> --}}

                    @auth
                        <form action="{{ route('news.like', $article['url']) }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary">Like</button>
                        </form>

                        <form action="{{ route('news.comment', $article['url']) }}" method="POST" class="mt-2">
                            @csrf
                            <textarea name="comment" class="form-control" rows="2" placeholder="Add a comment"></textarea>
                            <button type="submit" class="btn btn-outline-secondary mt-2">Comment</button>
                        </form>
                    @endauth
                </div>
            </div>
        @endforeach
        <div class="row mt-3">
            <div class="col-md-12">
                {{-- <iframe src="{{ $someUrl }}"></iframe> --}}
                <div id="news-iframe-container" ></div>
            </div>
        </div>
    @else
        <p>No news articles found.</p>
    @endif
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.read-more').click(function () {
                var newsUrl = $(this).data('news-url');
                var iframeHtml = '<iframe src="' + newsUrl + '" id="news-iframe" style="width: 100%; height: 500px; border: none;"></iframe>';
                var readLessButtonHtml = '<button class="btn btn-primary read-less mt-2">Read Less</button>';

                $('#news-iframe-container').html(iframeHtml + readLessButtonHtml);
            });

            // Handle click on "Read Less" button
            $(document).on('click', '.read-less', function () {
                $('#news-iframe-container').empty(); // Clear the container
            });
        });
    </script>
@endpush
