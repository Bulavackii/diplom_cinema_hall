<?php
namespace App\Http\Controllers;

use App\Models\MovieSession;
use App\Models\Ticket;
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
    $sessions = MovieSession::with('movie', 'cinemaHall')
    ->where('start_time', '>=', now())
    ->orderBy('start_time')
    ->get();

$movies = $sessions->groupBy(function($session) {
    return $session->movie->id; // Группировка по идентификатору фильма
});

return view('client.index', compact('movies'));

}


    // Страница выбора зала для фильма
    public function hall($id)
    {
        // Поиск сеанса с активным залом
        $session = MovieSession::with('movie', 'cinemaHall')
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
            'session_id' => 'required|integer|exists:movie_sessions,id',
            'seat_row' => 'required|integer|min:1',
            'seat_number' => 'required|integer|min:1',
        ]);

        // Получаем данные с формы
        $sessionId = $validatedData['session_id'];
        $seatRow = $validatedData['seat_row'];
        $seatNumber = $validatedData['seat_number'];

        // Проверка наличия сеанса
        $session = MovieSession::with('movie', 'cinemaHall')->findOrFail($sessionId);

        // Проверка, не занято ли уже место
        $isSeatBooked = Ticket::where('session_id', $sessionId)
            ->where('seat_row', $seatRow)
            ->where('seat_number', $seatNumber)
            ->exists();

        if ($isSeatBooked) {
            return back()->withErrors(['seat' => 'Это место уже занято. Пожалуйста, выберите другое место.']);
        }

        // Генерация уникального кода бронирования
        $bookingCode = strtoupper(Str::random(8)) . "-S{$sessionId}-R{$seatRow}-P{$seatNumber}";

        // Генерация содержимого QR-кода с информацией о сеансе, месте и коде бронирования
        $qrCodeContent = "Сеанс: {$session->movie->title}, Зал: {$session->cinemaHall->name}, Ряд: {$seatRow}, Место: {$seatNumber}, Время: {$session->start_time}, Код бронирования: {$bookingCode}";

        // Путь к файлу с QR-кодом
        $qrCodePath = public_path('qrcodes/' . $bookingCode . '.png');

        // Создайте папку, если её нет
        if (!file_exists(public_path('qrcodes'))) {
            mkdir(public_path('qrcodes'), 0755, true);
        }

        // Используем библиотеку Endroid\QrCode для генерации QR-кода
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($qrCodeContent)
            ->size(300)
            ->margin(10)
            ->build();

        // Сохранение файла QR-кода
        $result->saveToFile($qrCodePath);

        // Логирование для диагностики
        Log::info('QR-код содержимое: ' . $qrCodeContent);
        Log::info('Путь к QR-коду: ' . $qrCodePath);

        // Сохранение бронирования в базу данных (используем модель Ticket)
        Ticket::create([
            'session_id' => $sessionId,
            'seat_row' => $seatRow,
            'seat_number' => $seatNumber,
            'qr_code' => $qrCodePath,
        ]);

        // Отправляем данные на отображение билета
        return view('client.ticket', [
            'session' => $session,
            'seat_row' => $seatRow,
            'seat_number' => $seatNumber,
            'booking_code' => $bookingCode,
            'qrCodeUrl' => asset('qrcodes/' . $bookingCode . '.png'),
        ]);
    }
}