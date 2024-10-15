@extends('layouts.client')

@section('content')
    <div class="container mt-4">
        <h1>{{ $movie->title }}</h1>
        <p>{{ $movie->description }}</p>
        <p><strong>Жанр:</strong> {{ $movie->genre }}</p>
        <p><strong>Страна:</strong> {{ $movie->country }}</p>
        <p><strong>Длительность:</strong> {{ $movie->duration }} минут</p>
        @if ($movie->poster_url)
            <img src="{{ asset($movie->poster_url) }}" alt="{{ $movie->title }}" style="width: 200px; height: auto;">
        @endif
    </div>
@endsection
