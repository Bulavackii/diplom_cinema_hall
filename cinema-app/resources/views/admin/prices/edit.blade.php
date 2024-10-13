@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Редактировать цену</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.prices.update', $price->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="movie_session_id" class="form-label">Сеанс:</label>
                <select name="movie_session_id" id="movie_session_id" class="form-select">
                    <option value="">Выберите сеанс</option>
                    @foreach($movieSessions as $session)
                        <option value="{{ $session->id }}" {{ $session->id == $price->movie_session_id ? 'selected' : '' }}>
                            {{ $session->movie->title }} - {{ \Carbon\Carbon::parse($session->start_time)->format('d.m.Y H:i') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="cinema_hall_id" class="form-label">Зал:</label>
                <select name="cinema_hall_id" id="cinema_hall_id" class="form-select">
                    <option value="">Выберите зал</option>
                    @foreach($cinemaHalls as $hall)
                        <option value="{{ $hall->id }}" {{ $hall->id == $price->cinema_hall_id ? 'selected' : '' }}>
                            {{ $hall->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="seat_type" class="form-label">Тип места:</label>
                <select name="seat_type" id="seat_type" class="form-select" required>
                    <option value="standard" {{ $price->seat_type == 'standard' ? 'selected' : '' }}>Стандарт</option>
                    <option value="vip" {{ $price->seat_type == 'vip' ? 'selected' : '' }}>VIP</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Цена:</label>
                <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" id="price" step="0.01" value="{{ $price->price }}" required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            <a href="{{ route('admin.prices.index') }}" class="btn btn-secondary ms-2">Отмена</a>
        </form>
    </div>
@endsection
