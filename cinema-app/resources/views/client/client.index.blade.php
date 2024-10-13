<!-- resources/views/client/index.blade.php -->

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Онлайн-кинотеатр</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .movie-card {
            max-width: 350px;
            margin: 20px;
            border-radius: 15px;
            overflow: hidden;
        }
        .movie-card img {
            max-height: 400px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Добро пожаловать в онлайн-кинотеатр!</h1>

        <!-- Ссылка на админ панель, если пользователь авторизован -->
        @auth
            <div class="text-center mb-3">
                <a href="{{ route('admin.index') }}" class="btn btn-primary">Админ панель</a>
            </div>
        @endauth

        <h2 class="text-center mb-4">Выберите фильм для бронирования билетов:</h2>

        <div class="row justify-content-center">
            @if($movies->isEmpty())
                <div class="col-12">
                    <p class="text-center text-danger">В настоящее время нет доступных сеансов.</p>
                </div>
            @else
                @foreach($movies as $movieSessions)
                    @php
                        $movie = $movieSessions->first()->movie;
                    @endphp
                    <div class="col-md-4">
                        <div class="card movie-card shadow-sm">
                            @if($movie->poster_url)
                                <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" class="card-img-top">
                            @else
                                <img src="{{ asset('client/i/default-poster.jpg') }}" alt="{{ $movie->title }}" class="card-img-top">
                            @endif
                            <div class="card-body">
                                <h4 class="card-title">{{ $movie->title }}</h4>
                                <p class="card-text">{{ Str::limit($movie->description, 150) }}</p>
                                <p><strong>Длительность:</strong> {{ $movie->duration }} минут</p>
                                <p><strong>Страна:</strong> {{ $movie->country }}</p>
                                <p><strong>Жанр:</strong> {{ $movie->genre }}</p>

                                <h5 class="mt-4">Доступные сеансы:</h5>
                                <ul class="list-unstyled">
                                    @foreach($movieSessions as $session)
                                        <li class="mb-2">
                                            <span>Время: {{ $session->start_time->format('d.m.Y H:i') }} в зале {{ $session->cinemaHall->name }}</span><br>
                                            <a href="{{ route('client.hall', ['id' => $session->id]) }}" class="btn btn-sm btn-success mt-1">Забронировать билеты</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Декоративная линия снизу -->
        <hr class="my-5">

        <footer class="text-center">
            <p>© {{ date('Y') }} Онлайн-кинотеатр</p>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
