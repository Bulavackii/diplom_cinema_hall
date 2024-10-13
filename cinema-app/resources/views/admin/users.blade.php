@extends('layouts.admin')

@section('content')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-dark text-white text-center">
                <h2 class="mb-0">Список Администраторов и Зрителей</h2>
            </div>
            <div class="card-body">
                <div class="row mt-4 justify-content-center">
                    <div class="col-md-5">
                        <div class="card text-white bg-primary mb-4 shadow-sm" style="min-height: 300px;"> {{-- Задаем минимальную высоту --}}
                            <div class="card-header text-center">Администраторы</div>
                            <div class="card-body text-center">
                                <h5 class="card-title">Список Администраторов</h5>
                                <ul class="list-group list-group-flush text-dark">
                                    @forelse ($admins as $admin)
                                        <li class="list-group-item">{{ $admin->name }} ({{ $admin->email }})</li>
                                    @empty
                                        <li class="list-group-item">Администраторы отсутствуют</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card text-white bg-success mb-4 shadow-sm" style="min-height: 300px;"> {{-- Задаем минимальную высоту --}}
                            <div class="card-header text-center">Зрители</div>
                            <div class="card-body text-center">
                                <h5 class="card-title">Список Зрителей</h5>
                                <ul class="list-group list-group-flush text-dark">
                                    @forelse ($guests as $guest)
                                        <li class="list-group-item">{{ $guest->name }} ({{ $guest->email }})</li>
                                    @empty
                                        <li class="list-group-item">Зрители отсутствуют</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection