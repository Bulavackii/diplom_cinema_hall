@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <h2>Добавить новый фильм</h2>

        <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Название фильма:</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Описание:</label>
                <textarea class="form-control" id="description" name="description" required>{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="country" class="form-label">Страна:</label>
                <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}" required>
            </div>

            <div class="mb-3">
                <label for="genre" class="form-label">Жанр:</label>
                <input type="text" class="form-control" id="genre" name="genre" value="{{ old('genre') }}" required>
            </div>

            <div class="mb-3">
                <label for="duration" class="form-label">Длительность (в минутах):</label>
                <input type="number" class="form-control" id="duration" name="duration" value="{{ old('duration') }}" required>
            </div>

            <div class="mb-3">
                <label for="poster" class="form-label">Постер фильма:</label>
                <input type="file" class="form-control" id="poster" name="poster" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Добавить фильм</button>
        </form>
    </div>
@endsection
