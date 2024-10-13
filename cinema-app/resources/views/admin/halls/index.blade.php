{{-- index.blade.php --}}

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление залами</title>
    <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <header class="container mt-4">
        <h1>Управление залами</h1>
    </header>

    <div class="container mt-4">
        <div class="actions mb-3">
            <a href="{{ route('admin.index') }}" class="btn btn-secondary">Назад в админку</a>
            <a href="{{ route('admin.halls.create') }}" class="btn btn-success float-end">Добавить новый зал</a>
        </div>

        <section>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Название зала</th>
                        <th>Количество рядов</th>
                        <th>Количество мест в ряду</th>
                        <th>Активный</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cinemaHalls as $hall)
                        <tr>
                            <td>{{ $hall->name }}</td>
                            <td>{{ $hall->rows }}</td>
                            <td>{{ $hall->seats_per_row }}</td>
                            <td>
                                <span class="badge {{ $hall->active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $hall->active ? 'Да' : 'Нет' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.halls.edit', $hall->id) }}" class="btn btn-primary btn-sm">Редактировать</a>
                                @if($hall->active)
                                    <form action="{{ route('admin.halls.deactivate', $hall->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-warning btn-sm">Приостановить</button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.halls.activate', $hall->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-success btn-sm">Открыть продажу билетов</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>
