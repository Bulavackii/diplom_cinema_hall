<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\CinemaHall;
use App\Models\MovieSession;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
{
    $cinemaHalls = CinemaHall::all();
    $movies = Movie::all();
    $sessions = MovieSession::with('movies', 'cinemaHall')->get();

    // Подсчитываем количество администраторов и зрителей
    $adminsCount = User::where('role', 'admin')->count();
    $guestsCount = User::where('role', 'guest')->count();

    return view('admin.index', compact('cinemaHalls', 'movies', 'sessions', 'adminsCount', 'guestsCount'));
}

    public function users()
    {
        $admins = User::where('role', 'admin')->get();
        $guests = User::where('role', 'guest')->get();

        return view('admin.users', compact('admins', 'guests'));
    }


    public function sessions()
    {
        $sessions = MovieSession::with('movies', 'cinemaHall')->get();
        return view('admin.sessions.index', compact('sessions'));
    }

    public function createSessionForm()
    {
        $movies = Movie::all();
        $cinemaHalls = CinemaHall::all();
        return view('admin.sessions.create', compact('movies', 'cinemaHalls'));
    }

    public function storeSession(Request $request)
{
    $validated = $request->validate([
        'cinema_hall_id' => 'required|exists:cinema_halls,id',
        'start_time'     => 'required|date_format:Y-m-d\TH:i',
        'end_time'       => 'required|date_format:Y-m-d\TH:i|after:start_time',
        'movie_ids'      => 'required|array',
        'movie_ids.*'    => 'exists:movies,id',
    ]);

    $validated['start_time'] = Carbon::parse($validated['start_time']);
    $validated['end_time'] = Carbon::parse($validated['end_time']);

    // Создаем сеанс
    $session = MovieSession::create([
        'cinema_hall_id' => $validated['cinema_hall_id'],
        'start_time' => $validated['start_time'],
        'end_time' => $validated['end_time'],
    ]);

    // Привязываем фильмы к сеансу через промежуточную таблицу
    $session->movies()->sync($validated['movie_ids']); // Привязка фильмов

    return redirect()->route('admin.sessions.index')->with('status', 'Сеанс успешно добавлен.');
}



    public function editSessionForm($id)
    {
        $session = MovieSession::findOrFail($id);
        $movies = Movie::all();
        $cinemaHalls = CinemaHall::all();
        return view('admin.sessions.edit', compact('session', 'movies', 'cinemaHalls'));
    }

    public function updateSession(Request $request, $id)
    {
        $validated = $request->validate([
            'cinema_hall_id' => 'required|exists:cinema_halls,id',
            'start_time'     => 'required|date_format:Y-m-d\TH:i',
            'end_time'       => 'required|date_format:Y-m-d\TH:i|after:start_time',
            'movie_ids'      => 'required|array',
            'movie_ids.*'    => 'exists:movies,id',
        ]);

        $session = MovieSession::findOrFail($id);

        $session->update([
            'cinema_hall_id' => $request->cinema_hall_id,
            'start_time'     => Carbon::parse($request->start_time),
            'end_time'       => Carbon::parse($request->end_time),
        ]);

        $session->movies()->sync($request->movie_ids);

        return redirect()->route('admin.sessions.index')->with('status', 'Сеанс успешно обновлен');
    }

    public function deleteSession($id)
    {
        $session = MovieSession::findOrFail($id);
        $session->movies()->detach();
        $session->delete();

        return redirect()->route('admin.sessions.index')->with('status', 'Сеанс успешно удален');
    }

    public function adminDashboard()
{
    $admins = User::where('role', 'admin')->get(); // Предполагаем, что в модели User есть поле role
    $guests = User::where('role', 'guest')->get();

    return view('admin.index', compact('admins', 'guests'));
}

public function halls()
{
    $cinemaHalls = CinemaHall::all();
    return view('admin.halls.index', compact('cinemaHalls'));
}

public function editHallForm($id)
{
    $hall = CinemaHall::findOrFail($id);
    return view('admin.halls.edit', compact('hall'));
}

public function movies()
{
    $movies = Movie::all();
    return view('admin.movies.index', compact('movies'));
}
public function deactivateHall($id)
{
    $hall = CinemaHall::findOrFail($id);
    $hall->active = false; // Предполагается, что есть поле "active" в таблице залов
    $hall->save();

    return redirect()->route('admin.halls.index')->with('status', 'Зал успешно деактивирован');
}

public function activateHall($id)
{
    $hall = CinemaHall::findOrFail($id);
    $hall->active = true; // Предполагается, что есть поле "active" в таблице залов
    $hall->save();

    return redirect()->route('admin.halls.index')->with('status', 'Зал успешно активирован');
}

}
