@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Управление Сеансами</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.seances.create') }}" class="btn btn-primary mb-3">Создать Новый Сеанс</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Фильм</th>
                <th>Зал</th>
                <th>Время Начала</th>
                <th>Время Окончания</th>
                <th>Цена (Регуляр)</th>
                <th>Цена (VIP)</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($seances as $seance)
                <tr>
                    <td>{{ $seance->id }}</td>
                    <td>{{ $seance->movie->title }}</td>
                    <td>{{ $seance->cinemaHall->name }}</td>
                    <td>{{ $seance->start_time->format('d.m.Y H:i') }}</td>
                    <td>{{ $seance->end_time->format('d.m.Y H:i') }}</td>
                    <td>{{ $seance->price_regular }}</td>
                    <td>{{ $seance->price_vip }}</td>
                    <td>
                        <a href="{{ route('admin.seances.edit', $seance->id) }}" class="btn btn-sm btn-warning">Редактировать</a>
                        <form action="{{ route('admin.seances.destroy', $seance->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
