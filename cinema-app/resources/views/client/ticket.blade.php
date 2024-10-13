<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ваш билет</title>
    <link rel="stylesheet" href="{{ asset('client/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/styles.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .qr-code {
            margin-top: 20px;
        }
        section {
            border: 1px solid #ddd;
            padding: 20px;
            margin: 20px;
            border-radius: 8px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }
        footer {
            text-align: center;
            margin-top: 30px;
        }
        header {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Ваш билет</h1>
    </header>

    <section>
        <p>Фильм: {{ $session->movie->title }}</p>
        <p>Зал: {{ $session->cinemaHall->name }}</p>
        <p>Место: {{ $seat_row }} ряд, {{ $seat_number }} место</p>
        <p>Время сеанса: {{ $session->start_time->format('H:i, d F Y') }}</p>
        <p>Код бронирования: {{ $booking_code }}</p>

        @if($qrCodeUrl)
        <div class="qr-code">
            <img src="{{ $qrCodeUrl }}" alt="QR-код билета">
        </div>
        @else
        <p>QR-код не был сгенерирован.</p>
        @endif
    </section>

    <footer>
        <img src="{{ asset('client/i/border-bottom.png') }}" alt="Декоративная линия снизу">
        <p>&copy; 2024 Онлайн-кинотеатр</p>
    </footer>

    <script src="{{ asset('ad/js/accordeon.js') }}"></script>
</body>
</html>
