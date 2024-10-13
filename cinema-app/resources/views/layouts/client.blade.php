<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('client/css/styles.css') }}">
</head>
<body>
    <header>
        <h1>@yield('header')</h1>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2024 Онлайн-кинотеатр</p>
    </footer>
</body>
</html>
