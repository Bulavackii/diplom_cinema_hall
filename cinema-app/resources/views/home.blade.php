@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h3>{{ __('Личный Кабинет') }}</h3>
                </div>

                <div class="card-body text-center">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <h5>{{ __('Добро пожаловать, ') }} {{ Auth::user()->name }}!</h5>
                    <p class="lead">{{ __('Вы успешно вошли в систему.') }}</p>

                    <div class="mt-4">
                        <a href="{{ route('client.index') }}" class="btn btn-primary me-2">Перейти к фильмам</a>
                        <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">Административная панель</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
