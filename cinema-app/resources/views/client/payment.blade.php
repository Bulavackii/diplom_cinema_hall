<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оплата</title>
    <link rel="stylesheet" href="{{ asset('client/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/styles.css') }}">
</head>
<body>
    <header>
        <h1>Оплата билета</h1>
    </header>

    <section>
        <form action="{{ route('client.complete_payment') }}" method="POST">
            @csrf
            <div class="payment-info">
                <label for="seat">Выбранное место: {{ $seat->row }} ряд, {{ $seat->seat_number }} место</label>
                <label for="price">Цена: {{ $seat->price }} руб.</label>
            </div>

            <div class="payment-method">
                <label for="card-number">Номер карты:</label>
                <input type="text" name="card_number" id="card-number" required>

                <label for="expiry-date">Дата окончания:</label>
                <input type="text" name="expiry_date" id="expiry-date" required>

                <label for="cvc">CVC:</label>
                <input type="text" name="cvc" id="cvc" required>
            </div>

            <button type="submit">Оплатить</button>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 Онлайн-кинотеатр</p>
    </footer>

    <script src="{{ asset('ad/js/accordeon.js') }}"></script>
</body>
</html>