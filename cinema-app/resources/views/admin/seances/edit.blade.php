@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Редактировать Сеанс</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Упс!</strong> Есть некоторые проблемы с вашими данными.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.seances.update', $seance->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="movie_id">Фильм:</label>
            <select name="movie_id" class="form-control" required>
                <option value="">-- Выберите фильм --</option>
                @foreach($movies as $movie)
                    <option value="{{ $movie->id }}" {{ (old('movie_id') ?? $seance->movie_id) == $movie->id ? 'selected' : '' }}>
                        {{ $movie->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="cinema_hall_id">Зал:</label>
            <select name="cinema_hall_id" class="form-control" required>
                <option value="">-- Выберите зал --</option>
                @foreach($cinemaHalls as $hall)
                    <option value="{{ $hall->id }}" {{ (old('cinema_hall_id') ?? $seance->cinema_hall_id) == $hall->id ? 'selected' : '' }}>
                        {{ $hall->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="start_time">Время Начала:</label>
            <input type="datetime-local" name="start_time" class="form-control" value="{{ old('start_time') ? date('Y-m-d\TH:i', strtotime(old('start_time'))) : $seance->start_time->format('Y-m-d\TH:i') }}" required>
        </div>

        <div class="form-group">
            <label for="end_time">Время Окончания:</label>
            <input type="datetime-local" name="end_time" class="form-control" value="{{ old('end_time') ? date('Y-m-d\TH:i', strtotime(old('end_time'))) : $seance->end_time->format('Y-m-d\TH:i') }}" required>
        </div>

        <div class="form-group">
            <label for="price_regular">Цена (Регуляр):</label>
            <input type="number" step="0.01" name="price_regular" class="form-control" value="{{ old('price_regular') ?? $seance->price_regular }}" required>
        </div>

        <div class="form-group">
            <label for="price_vip">Цена (VIP):</label>
            <input type="number" step="0.01" name="price_vip" class="form-control" value="{{ old('price_vip') ?? $seance->price_vip }}" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Сохранить Изменения</button>
        <a href="{{ route('admin.seances.index') }}" class="btn btn-secondary mt-3">Отмена</a>
    </form>
</div>
@endsection
