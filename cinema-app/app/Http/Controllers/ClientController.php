<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use App\Models\Ticket;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class ClientController extends Controller
{
    // Главная страница с расписанием фильмов
    public function index()
{
    $seances = Seance::with(['movie', 'cinemaHall'])
                      ->where('start_time', '>=', now())
                      ->orderBy('start_time', 'asc')
                      ->get();

    // Группируем сеансы по фильму
    $movies = $seances->groupBy('movie_id');

    return view('client.index', compact('movies'));
}

    // Страница выбора зала для фильма
    public function hall($id)
    {
        // Поиск сеанса с активным залом
        $session = Seance::with(['movie', 'cinemaHall'])
                         ->whereHas('cinemaHall', function ($query) {
                             $query->where('active', true);
                         })
                         ->findOrFail($id);

        // Получаем количество рядов и мест в зале
        $rows = $session->cinemaHall->rows;
        $seatsPerRow = $session->cinemaHall->seats_per_row;

        // Получаем забронированные места для данного сеанса
        $bookedSeats = Ticket::where('session_id', $session->id)->get(['seat_row', 'seat_number']);

        return view('client.hall', compact('session', 'rows', 'seatsPerRow', 'bookedSeats'));
    }

    // Обработка завершения бронирования
    public function completeBooking(Request $request)
    {
        // Проверка валидности входных данных
        $validatedData = $request->validate([
            'session_id' => 'required|integer|exists:seances,id',
            'seats' => 'required|array|min:1',
            'seats.*' => 'string|regex:/^\d+-\d+$/',
        ]);

        // Получаем данные с формы
        $sessionId = $validatedData['session_id'];
        $selectedSeats = $validatedData['seats'];

        // Получение сеанса
        $session = Seance::with(['movie', 'cinemaHall'])->findOrFail($sessionId);

        $user = auth()->user();

        // Проверка и создание билетов
        $bookedTickets = [];
        foreach ($selectedSeats as $seatStr) {
            list($seatRow, $seatNumber) = explode('-', $seatStr);

            // Проверка, не занято ли уже место
            $isSeatBooked = Ticket::where('session_id', $sessionId)
                ->where('seat_row', $seatRow)
                ->where('seat_number', $seatNumber)
                ->exists();

            if ($isSeatBooked) {
                return back()->withErrors(['seat' => "Место ряд {$seatRow}, номер {$seatNumber} уже занято."]);
            }

            // Генерация уникального кода бронирования
            $bookingCode = strtoupper(Str::random(8)) . "-S{$sessionId}-R{$seatRow}-P{$seatNumber}";

            // Генерация содержимого QR-кода
            $qrCodeContent = "Сеанс: {$session->movie->title}, Зал: {$session->cinemaHall->name}, Ряд: {$seatRow}, Место: {$seatNumber}, Время: {$session->start_time}, Код бронирования: {$bookingCode}";

            // Путь к файлу с QR-кодом
            $qrCodePath = public_path('qrcodes/' . $bookingCode . '.png');

            // Создание директории, если она не существует
            if (!file_exists(public_path('qrcodes'))) {
                mkdir(public_path('qrcodes'), 0755, true);
            }

            // Генерация и сохранение QR-кода
            $result = Builder::create()
                ->writer(new PngWriter())
                ->data($qrCodeContent)
                ->size(300)
                ->margin(10)
                ->build();

            $result->saveToFile($qrCodePath);

            // Логирование для диагностики
            Log::info('QR-код содержимое: ' . $qrCodeContent);
            Log::info('Путь к QR-коду: ' . $qrCodePath);

            // Сохранение бронирования в базу данных
            $ticket = Ticket::create([
                'session_id' => $sessionId,
                'seat_row' => $seatRow,
                'seat_number' => $seatNumber,
                'user_id' => $user->id,
                'qr_code' => 'qrcodes/' . $bookingCode . '.png', // относительный путь
            ]);

            $bookedTickets[] = $ticket;
        }

        // Можно вернуть на страницу билета или список билетов
        // Предположим, что вы хотите показать первый билет
        $ticket = $bookedTickets[0];

        return view('client.ticket', [
            'session' => $session,
            'seat_row' => $ticket->seat_row,
            'seat_number' => $ticket->seat_number,
            'booking_code' => $bookingCode,
            'qrCodeUrl' => asset($ticket->qr_code),
        ]);
    }
    public function showMovieDetails($id)
{
    $movie = Movie::findOrFail($id);
    return view('client.movie.details', compact('movie'));
}

}