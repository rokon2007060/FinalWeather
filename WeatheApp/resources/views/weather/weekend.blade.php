@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Weekend Forecast</h2>
    @if(isset($weather))
        <div class="row">
            @foreach($weather['list'] as $day)
                @if(date('N', $day['dt']) >= 5)
                    <div class="col-md-3 mb-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <p><strong>{{ date('D, M d', $day['dt']) }}</strong></p>
                                <p>{{ $day['temp']['day'] }} °C</p>
                                <p>{{ ucfirst($day['weather'][0]['description']) }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @elseif(isset($error))
        <div class="alert alert-danger text-center">
            <p>{{ $error }}</p>
        </div>
    @endif
</div>
@endsection
