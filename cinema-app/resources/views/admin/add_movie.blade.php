@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Список сеансов</h2>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Фильм</th>
                        <th>Зал</th>
                        <th>Время начала</th>
                        <th>Время окончания</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sessions as $session)
                        <tr>
                            <td>{{ $session->movie->title }}</td>
                            <td>{{ $session->cinemaHall->name }}</td>
                            <td>{{ $session->start_time->format('d.m.Y H:i') }}</td>
                            <td>{{ $session->end_time->format('d.m.Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.seances.edit', $session->id) }}" class="btn btn-sm btn-primary">Редактировать</a>
                                <form action="{{ route('admin.seances.destroy', $session->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены, что хотите удалить этот сеанс?')">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
