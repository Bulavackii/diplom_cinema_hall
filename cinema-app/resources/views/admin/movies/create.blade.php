@extends('layouts.admin')

@section('content')
    <div class="container mt-5 d-flex justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header bg-dark text-white text-center">
                    <h2 class="mb-0">Добавить Новый Фильм</h2>
                </div>
                <div class="card-body" style="background-color: #f8f9fa;">
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

                    <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Название фильма:</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" required value="{{ old('title') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Описание:</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="country" class="form-label">Страна выпуска:</label>
                            <input type="text" class="form-control @error('country') is-invalid @enderror" name="country" id="country" required value="{{ old('country') }}">
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="genre" class="form-label">Жанр:</label>
                            <input type="text" class="form-control @error('genre') is-invalid @enderror" name="genre" id="genre" required value="{{ old('genre') }}">
                            @error('genre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="duration" class="form-label">Длительность (в минутах):</label>
                            <input type="number" class="form-control @error('duration') is-invalid @enderror" name="duration" id="duration" required value="{{ old('duration') }}">
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="poster" class="form-label">Постер фильма:</label>
                            <input type="file" class="form-control @error('poster') is-invalid @enderror" name="poster" id="poster" accept="image/*">
                            @error('poster')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary me-3 shadow-sm" style="border-radius: 50px;"><i class="bi bi-plus-circle"></i> Добавить Фильм</button>
                            <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary shadow-sm" style="border-radius: 50px;">Отмена</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush