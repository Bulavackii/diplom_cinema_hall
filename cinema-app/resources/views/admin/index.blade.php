@extends('layouts.admin')

@section('content')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-dark text-white text-center">
                <h2 class="mb-0">Административная панель</h2>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

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

                <div class="row mt-4 justify-content-center">
                    <div class="col-md-4">
                        <div class="card text-white bg-info mb-4 shadow-sm" style="min-height: 250px;"> {{-- Задаем минимальную высоту --}}
                            <div class="card-header text-center">Пользователи</div>
                            <div class="card-body text-center">
                                <h5 class="card-title">Админы и зрители</h5>
                                <p class="card-text">Всего администраторов: {{ $adminsCount }}
                                Всего зрителей: {{ $guestsCount }}</p>
                                <a href="{{ route('admin.users') }}" class="btn btn-light">Подробнее</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-primary mb-4 shadow-sm" style="min-height: 250px;"> {{-- Задаем минимальную высоту --}}
                            <div class="card-header text-center">Управление Залами</div>
                            <div class="card-body text-center">
                                <h5 class="card-title">Залы Кинотеатра</h5>
                                <p class="card-text">Создание, редактирование и удаление залов кинотеатра.</p>
                                <a href="{{ route('admin.halls.index') }}" class="btn btn-light">Перейти</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-4 shadow-sm" style="min-height: 250px;"> {{-- Задаем минимальную высоту --}}
                            <div class="card-header text-center">Управление Сеансами</div>
                            <div class="card-body text-center">
                                <h5 class="card-title">Сеансы Фильмов</h5>
                                <p class="card-text">Создание и управление сеансами фильмов.</p>
                                <a href="{{ route('admin.seances.index') }}" class="btn btn-light">Перейти</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-warning mb-4 shadow-sm" style="min-height: 250px;"> {{-- Задаем минимальную высоту --}}
                            <div class="card-header text-center">Управление Фильмами</div>
                            <div class="card-body text-center">
                                <h5 class="card-title">Фильмы</h5>
                                <p class="card-text">Добавление и управление фильмами в системе.</p>
                                <a href="{{ route('admin.movies.index') }}" class="btn btn-light">Перейти</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
