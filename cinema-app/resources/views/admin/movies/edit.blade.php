@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <h2>Редактировать фильм</h2>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Название фильма:</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ old('title', $movie->title) }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Описание:</label>
                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" required>{{ old('description', $movie->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="country" class="form-label">Страна выпуска:</label>
                <input type="text" class="form-control @error('country') is-invalid @enderror" name="country" id="country" value="{{ old('country', $movie->country) }}" required>
                @error('country')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="genre" class="form-label">Жанр:</label>
                <input type="text" class="form-control @error('genre') is-invalid @enderror" name="genre" id="genre" value="{{ old('genre', $movie->genre) }}" required>
                @error('genre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="duration" class="form-label">Длительность (в минутах):</label>
                <input type="number" class="form-control @error('duration') is-invalid @enderror" name="duration" id="duration" value="{{ old('duration', $movie->duration) }}" required>
                @error('duration')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="poster" class="form-label">Постер фильма:</label>
                <input type="file" class="form-control @error('poster') is-invalid @enderror" name="poster" id="poster" accept="image/*">
                
                @if ($movie->poster_url)
                    <div class="mt-2">
                        <img src="{{ asset($movie->poster_url) }}" alt="Текущий постер" style="width: 150px; height: auto;">
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="delete_poster" id="delete_poster" value="1">
                        <label class="form-check-label" for="delete_poster">
                            Удалить текущий постер
                        </label>
                    </div>
                @endif
                @error('poster')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        </form>
    </div>
@endsection
