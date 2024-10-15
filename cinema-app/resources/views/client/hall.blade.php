@extends('layouts.client')

@section('content')
    <div class="container">
        <h2 class="text-center mt-4">Выберите места для сеанса "{{ $session->movie->title }}"</h2>
        <p class="text-center">Зал: {{ $session->cinemaHall->name }}</p>
        <p class="text-center">Время: {{ $session->start_time->format('d.m.Y H:i') }}</p>

        <!-- Отображение схемы зала -->
        <h3 class="text-center mt-5">Схема зала</h3>
        <div class="hall-layout d-flex flex-column align-items-center mt-3">
            @for ($row = 1; $row <= $rows; $row++)
                <div class="row mb-2">
                    <span class="mr-3"><strong>Ряд {{ $row }}:</strong></span>
                    @for ($seat = 1; $seat <= $seatsPerRow; $seat++)
                    @php
                    $isBooked = in_array($row . '-' . $seat, $bookedSeats->toArray());
                @endphp

                        <label class="seat">
                            <input type="checkbox" name="seats[]" value="{{ $row }}-{{ $seat }}" {{ $isBooked ? 'disabled' : '' }}>
                            <span class="{{ $isBooked ? 'booked' : '' }}">{{ $seat }}</span>
                        </label>
                    @endfor
                </div>
            @endfor
        </div>

        <!-- Форма для бронирования -->
        <form id="bookingForm" action="{{ route('client.complete_booking') }}" method="POST" target="_blank" class="text-center mt-5">
            @csrf
            <input type="hidden" name="session_id" value="{{ $session->id }}">
            <input type="hidden" name="selected_seats" id="selectedSeatsInput">
            <button type="button" class="btn btn-primary" onclick="completeBooking()">Забронировать выбранные места</button>
        </form>
    </div>

    <style>
        .hall-layout {
            display: flex;
            flex-direction: column;
            max-width: 600px;
        }
        .row {
            display: flex;
            align-items: center;
        }
        .seat {
            display: inline-block;
            margin-right: 5px;
        }
        .seat input[type="checkbox"] {
            display: none;
        }
        .seat span {
            display: inline-block;
            padding: 8px 12px;
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
        }
        .seat span.booked {
            background-color: #f44336;
            cursor: not-allowed;
        }
        .seat input[type="checkbox"]:checked + span {
            background-color: #ff9800;
        }
    </style>

    <script>
        function completeBooking() {
            const selectedSeats = document.querySelectorAll('input[name="seats[]"]:checked');
            if (selectedSeats.length === 0) {
                alert('Пожалуйста, выберите хотя бы одно место для бронирования.');
                return;
            }

            let selectedSeatsValue = [];
            selectedSeats.forEach(seat => {
                selectedSeatsValue.push(seat.value);
            });

            document.getElementById('selectedSeatsInput').value = selectedSeatsValue.join(',');

            // Отправляем форму бронирования
            const bookingForm = document.getElementById('bookingForm');
            bookingForm.submit();
        }
    </script>
@endsection
