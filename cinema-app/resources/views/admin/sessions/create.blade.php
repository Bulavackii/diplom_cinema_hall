@extends('layouts.admin')

@section('content')
    <div class="container mt-5 d-flex justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="mb-0">Добавить новый сеанс</h2>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.sessions.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="movie_ids" class="form-label">Фильмы:</label>
                            <select name="movie_ids[]" id="movie_ids" class="form-select @error('movie_ids') is-invalid @enderror" multiple required>
                                @foreach ($movies as $movie)
                                    <option value="{{ $movie->id }}" data-poster-url="{{ asset($movie->poster_url) }}">
                                        {{ $movie->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('movie_ids')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Блок для отображения постеров -->
                        <div class="mb-4" id="movie_posters" style="display: flex; flex-wrap: wrap;">
                        </div>

                        <div class="mb-4">
                            <label for="cinema_hall_id" class="form-label">Зал:</label>
                            <select name="cinema_hall_id" id="cinema_hall_id" class="form-select @error('cinema_hall_id') is-invalid @enderror" required>
                                @foreach ($cinemaHalls as $hall)
                                    <option value="{{ $hall->id }}">{{ $hall->name }}</option>
                                @endforeach
                            </select>
                            @error('cinema_hall_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="start_time" class="form-label">Время начала:</label>
                            <input type="datetime-local" class="form-control @error('start_time') is-invalid @enderror" name="start_time" id="start_time" value="{{ old('start_time') }}" required>
                            @error('start_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="end_time" class="form-label">Время окончания:</label>
                            <input type="datetime-local" class="form-control @error('end_time') is-invalid @enderror" name="end_time" id="end_time" value="{{ old('end_time') }}" required>
                            @error('end_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.sessions.index') }}" class="btn btn-secondary">Отмена</a>
                            <button type="submit" class="btn btn-primary">Добавить сеанс</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        #movie_posters img {
            max-height: 150px;
            margin-right: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            transition: transform 0.3s;
        }
        #movie_posters img:hover {
            transform: scale(1.05);
        }
    </style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const movieSelect = document.getElementById('movie_ids');
        const moviePostersDiv = document.getElementById('movie_posters');

        function updateMoviePosters() {
            moviePostersDiv.innerHTML = ''; // Очищаем блок с постерами

            Array.from(movieSelect.selectedOptions).forEach(option => {
                const posterUrl = option.getAttribute('data-poster-url');
                if (posterUrl) { // Проверяем, что постер существует
                    const img = document.createElement('img');
                    img.src = posterUrl;
                    img.alt = option.textContent;
                    img.classList.add('img-fluid', 'mb-2');
                    moviePostersDiv.appendChild(img);
                }
            });
        }

        movieSelect.addEventListener('change', updateMoviePosters);

        // Обновляем постеры при загрузке страницы
        updateMoviePosters();
    });
</script>
@endpush
