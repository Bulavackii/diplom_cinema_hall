@extends('layouts.admin')

@section('content')
    <div class="container mt-5 d-flex justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h2>Редактировать сеанс</h2>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.sessions.update', $session->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="movie_ids" class="form-label">Фильмы:</label>
                            <select name="movie_ids[]" id="movie_ids" class="form-control" multiple>
                                @foreach($movies as $movie)
                                    <option value="{{ $movie->id }}" {{ in_array($movie->id, $session->movies->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $movie->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="cinema_hall_id" class="form-label">Зал:</label>
                            <select name="cinema_hall_id" id="cinema_hall_id" class="form-control">
                                @foreach($cinemaHalls as $hall)
                                    <option value="{{ $hall->id }}" {{ $hall->id == $session->cinema_hall_id ? 'selected' : '' }}>
                                        {{ $hall->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="start_time" class="form-label">Время начала:</label>
                            <input type="datetime-local" class="form-control" name="start_time" value="{{ $session->start_time->format('Y-m-d\TH:i') }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="end_time" class="form-label">Время окончания:</label>
                            <input type="datetime-local" class="form-control" name="end_time" value="{{ $session->end_time->format('Y-m-d\TH:i') }}" required>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary me-2">Сохранить изменения</button>
                            <a href="{{ route('admin.sessions.index') }}" class="btn btn-secondary">Отмена</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
