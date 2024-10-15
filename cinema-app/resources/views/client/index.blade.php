{{-- resources/views/client/index.blade.php --}}
@extends('layouts.client')

@section('title', 'Сеансы')

@section('header', 'Сеансы')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            @if($movies->isEmpty())
                <p class="text-white text-center">В настоящее время нет доступных сеансов.</p>
            @else
                @foreach($movies as $movieGroup)
                    @php
                        // Получаем первый сеанс для получения информации о фильме
                        $firstSession = $movieGroup->first();
                        $movie = $firstSession->movie;
                    @endphp
                    <div class="col-md-4 d-flex align-items-stretch">
                        <div class="card movie-card shadow-lg">
                            @if($movie->poster_url)
                                <img src="{{ asset($movie->poster_url) }}" class="card-img-top" alt="{{ $movie->title }}">
                            @else
                                <img src="{{ asset('client/i/default-poster.jpg') }}" class="card-img-top" alt="{{ $movie->title }}">
                            @endif
                            <div class="card-body movie-info">
                                <h5 class="card-title">{{ $movie->title }}</h5>
                                <p class="card-text">
                                    {{ Str::limit($movie->description, 100) }} 
                                    <a href="{{ route('client.movie.details', $movie->id) }}" class="text-primary">Подробнее...</a>
                                </p>
                                <p><strong>Длительность:</strong> {{ $movie->duration }} минут</p>
                                <p><strong>Жанр:</strong> {{ $movie->genre }}</p>
                                <p><strong>Страна:</strong> {{ $movie->country }}</p>

                                <h6>Доступные сеансы:</h6>
                                <ul class="list-unstyled">
                                    @foreach($movieGroup as $session)
                                        <li class="mb-2">
                                            <span>Время: {{ $session->start_time->format('d.m.Y H:i') }} в зале {{ $session->cinemaHall->name }}</span>
                                            <a href="{{ route('client.hall', $session->id) }}" class="btn btn-sm btn-primary mt-1">Забронировать билеты</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('{{ asset('client/i/background.jpg') }}');
            background-size: cover;
            background-position: center;
        }
        header {
            text-align: center;
            color: #fff;
            margin-top: 20px;
        }
        .auth-links {
            text-align: center;
            margin-bottom: 20px;
        }
        .movie-card {
            max-width: 350px;
            margin: 20px auto;
            transition: transform 0.3s ease-in-out;
        }
        .movie-card:hover {
            transform: translateY(-10px);
        }
        .movie-card img {
            max-height: 400px;
            object-fit: cover;
        }
        .movie-info {
            text-align: left;
        }
        .footer {
            margin-top: 50px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('client/js/accordeon.js') }}"></script>
@endpush
