@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2>Список фильмов</h2>
        <a href="{{ route('admin.movies.create') }}" class="btn btn-primary mb-3">Добавить новый фильм</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Жанр</th>
                    <th>Страна</th>
                    <th>Длительность</th>
                    <th>Постер</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($movies as $movie)
                    <tr>
                        <td>{{ $movie->title }}</td>
                        <td>{{ $movie->genre }}</td>
                        <td>{{ $movie->country }}</td>
                        <td>{{ $movie->duration }} мин</td>
                        <td>
                            @if ($movie->poster_url)
                                <img src="{{ asset($movie->poster_url) }}" alt="{{ $movie->title }}" style="width: 100px; height: auto;">
                            @else
                                <span>Нет постера</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-warning btn-sm">Редактировать</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
