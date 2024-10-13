@extends('layouts.admin')

@section('content')
    <div class="container mt-5 d-flex justify-content-center">
        <div class="col-lg-8 text-center">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('admin.index') }}" class="btn btn-secondary shadow-sm" style="border-radius: 8px;">← Назад в админку</a>
                <h2 class="fw-bold text-primary text-center flex-grow-1">Управление Сеансами</h2>
                <a href="{{ route('admin.sessions.create') }}" class="btn btn-success shadow-sm" style="border-radius: 8px;">Добавить новый Сеанс</a>
            </div>

            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show text-center mx-auto" role="alert" style="max-width: 600px;">
                    {{ session('status') }}
                    {{-- Кнопка закрытия убрана --}}
                </div>
            @endif

            <div class="timeline position-relative d-flex flex-column align-items-center">
                @foreach($sessions as $session)
                    <div class="card mb-4 shadow-sm text-center" style="max-width: 600px;">
                        <div class="card-body">
                            <h4 class="session-title mb-3">Сеанс: {{ $session->formatted_start_time }} - {{ $session->formatted_end_time }}</h4>
                            @if ($session->movies->count())
                                <div class="d-flex justify-content-center flex-wrap">
                                    @foreach ($session->movies as $movie)
                                        <div class="movie-item mb-3 text-center mx-2" style="min-width: 200px;"> {{-- Минимальная ширина для центровки --}}
                                            @if ($movie->poster_url)
                                                <img src="{{ asset($movie->poster_url) }}" class="img-fluid mx-auto" style="max-height: 150px;" alt="{{ $movie->title }}">
                                            @endif
                                            <h5 class="mt-2">{{ $movie->title }}</h5>
                                            <p>{{ Str::limit($movie->description, 100) }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">Нет доступных фильмов для этого сеанса.</p>
                            @endif
                            <p><strong>Зал:</strong> {{ $session->cinemaHall->name }}</p>
                            <div class="d-flex justify-content-center mt-3">
                                <a href="{{ route('admin.sessions.edit', $session->id) }}" class="btn btn-outline-primary btn-sm me-2">Редактировать</a>
                                <form action="{{ route('admin.sessions.destroy', $session->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Вы уверены, что хотите удалить этот сеанс?')">Удалить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
