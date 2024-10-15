<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use App\Models\Movie;
use App\Models\CinemaHall;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Главная страница админки
    public function index()
    {
        // Получаем все сеансы с подгруженными данными о фильмах и залах
        $seances = Seance::with('movie', 'cinemaHall')->get();
        
        // Получаем количество администраторов и зрителей
        $adminsCount = User::where('role', 'admin')->count();
        $guestsCount = User::where('role', 'guest')->count();

        return view('admin.index', compact('seances', 'adminsCount', 'guestsCount'));
    }

    // Управление фильмами
    public function movies()
    {
        $movies = Movie::all();
        return view('admin.movies.index', compact('movies'));
    }

    public function addMovieForm()
    {
        return view('admin.movies.create');
    }

    // Метод для сохранения нового фильма
    public function storeMovie(Request $request)
    {
        // Валидация данных
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'country' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Проверка изображения
        ]);

        // Создаем фильм
        $movie = new Movie($validated);

        // Проверка и сохранение постера
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->move(public_path('client/i'), $request->file('poster')->getClientOriginalName());
            $movie->poster_url = 'client/i/' . $request->file('poster')->getClientOriginalName();
        }

        $movie->save();

        return redirect()->route('admin.movies.index')->with('success', 'Фильм успешно добавлен!');
    }

    // Метод для обновления существующего фильма
    public function updateMovie(Request $request, Movie $movie)
    {
        // Валидация данных
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'country' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Проверка изображения
            'delete_poster' => 'nullable|boolean'
        ]);

        // Обновление данных фильма
        $movie->fill($validated);

        // Если нужно удалить текущий постер
        if ($request->has('delete_poster') && $request->delete_poster) {
            if (file_exists(public_path($movie->poster_url))) {
                unlink(public_path($movie->poster_url));
            }
            $movie->poster_url = null;
        }

        // Проверка и обновление постера
        if ($request->hasFile('poster')) {
            if ($movie->poster_url && file_exists(public_path($movie->poster_url))) {
                unlink(public_path($movie->poster_url));
            }
            $posterPath = $request->file('poster')->move(public_path('client/i'), $request->file('poster')->getClientOriginalName());
            $movie->poster_url = 'client/i/' . $request->file('poster')->getClientOriginalName();
        }

        $movie->save();

        return redirect()->route('admin.movies.index')->with('success', 'Фильм успешно обновлен!');
    }

    // Управление пользователями
    public function users()
    {
        $admins = User::where('role', 'admin')->get();
        $guests = User::where('role', 'guest')->get();

        return view('admin.users', compact('admins', 'guests'));
    }

    // Управление залами
    public function halls()
    {
        $cinemaHalls = CinemaHall::all();
        return view('admin.halls.index', compact('cinemaHalls'));
    }

    public function editHallForm(CinemaHall $hall)
    {
        return view('admin.halls.edit', compact('hall'));
    }

    public function deactivateHall(CinemaHall $hall)
    {
        $hall->active = false; // Предполагается, что есть поле "active" в таблице залов
        $hall->save();

        return redirect()->route('admin.halls.index')->with('status', 'Зал успешно деактивирован');
    }

    public function activateHall(CinemaHall $hall)
    {
        $hall->active = true; // Предполагается, что есть поле "active" в таблице залов
        $hall->save();

        return redirect()->route('admin.halls.index')->with('status', 'Зал успешно активирован');
    }

    // Управление ценами (методы должны быть реализованы)
    public function prices()
    {
        // Реализуйте логику для управления ценами
        return view('admin.prices.index');
    }

    public function createPriceForm()
    {
        // Реализуйте логику для создания цены
        return view('admin.prices.create');
    }

    public function storePrice(Request $request)
    {
        // Реализуйте логику для сохранения цены
    }

    public function editPriceForm($price)
    {
        // Реализуйте логику для редактирования цены
    }

    public function updatePrice(Request $request, $price)
    {
        // Реализуйте логику для обновления цены
    }

    public function deletePrice($price)
    {
        // Реализуйте логику для удаления цены
    }

    // Dashboard
    public function adminDashboard()
    {
        $admins = User::where('role', 'admin')->get(); // Предполагаем, что в модели User есть поле role
        $guests = User::where('role', 'guest')->get();

        return view('admin.index', compact('admins', 'guests'));
    }

    public function createHallForm()
    {
        // Если используете модель CinemaHall, можно передать необходимые данные в представление
        // Например: $halls = CinemaHall::all();
        return view('admin.halls.create');
    }

    /**
     * Обрабатывает сохранение нового зала.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeHall(Request $request)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rows' => 'required|integer|min:1',
            'seats_per_row' => 'required|integer|min:1',
        ]);

        // Создание нового зала
        CinemaHall::create($validated);

        // Перенаправление с сообщением об успехе
        return redirect()->route('admin.halls.index')->with('success', 'Зал успешно создан!');
    }

    public function updateHall(Request $request, CinemaHall $hall)
{
    // Валидация данных
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'rows' => 'required|integer|min:1',
        'seats_per_row' => 'required|integer|min:1',
    ]);

    // Обновление данных о зале
    $hall->update($validated);

    // Перенаправление с сообщением об успешном обновлении
    return redirect()->route('admin.halls.index')->with('success', 'Зал успешно обновлен.');
}

}
