@extends('layouts.admin')

@section('content')
    <div class="container mt-5 d-flex justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mt-5">
                <a href="{{ route('admin.index') }}" class="btn btn-info shadow-sm" style="border-radius: 50px;"><i class="bi bi-arrow-left-circle"></i> Назад в Админку</a>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary">Список Фильмов</h2>
                <a href="{{ route('admin.movies.create') }}" class="btn btn-success shadow-sm" style="border-radius: 8px;">Добавить новый Фильм</a>
            </div>

            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($movies as $movie)
                    <div class="col">
                        <div class="card shadow-sm" style="border-radius: 15px; overflow: hidden;">
                            @if ($movie->poster_url)
                                <img src="{{ asset($movie->poster_url) }}" class="card-img-top" alt="{{ $movie->title }}">
                            @endif
                            <div class="card-body" style="background-color: #f8f9fa;">
                                <h5 class="card-title text-dark">{{ $movie->title }}</h5>
                                <p class="card-text"><strong>Описание:</strong> {{ Str::limit($movie->description, 100) }}</p>
                                <p class="card-text"><strong>Страна:</strong> {{ $movie->country }}</p>
                                <p class="card-text"><strong>Жанр:</strong> {{ $movie->genre }}</p>
                                <p class="card-text"><strong>Длительность:</strong> {{ $movie->duration }} минут</p>
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-outline-primary btn-sm shadow-sm" style="border-radius: 50px;">
                                        <i class="bi bi-pencil-square"></i> Редактировать
                                    </a>
                                    <form action="{{ route('admin.movies.destroy', $movie->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm shadow-sm" style="border-radius: 50px;" onclick="return confirm('Вы уверены, что хотите удалить этот фильм?')">
                                            <i class="bi bi-trash"></i> Удалить
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
<style>
    .card {
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .btn-outline-primary, .btn-outline-danger {
        transition: all 0.3s ease;
    }
    .btn-outline-primary:hover, .btn-outline-danger:hover {
        color: #fff;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush