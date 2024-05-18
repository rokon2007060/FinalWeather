@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Hourly Forecast</h2>
    @if(isset($weather))
        <div class="row">
            @foreach($weather['list'] as $hour)
                <div class="col-md-3 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <p><strong>{{ date('H:i', $hour['dt']) }} UTC</strong></p>
                            <p>{{ $hour['main']['temp'] }} °C</p>
                            <p>{{ ucfirst($hour['weather'][0]['description']) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @elseif(isset($error))
        <div class="alert alert-danger text-center">
            <p>{{ $error }}</p>
        </div>
    @endif
</div>
@endsection
