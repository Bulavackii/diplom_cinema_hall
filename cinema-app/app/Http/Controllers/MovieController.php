<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\MovieSession;
use App\Models\CinemaHall;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MovieController extends Controller
{
    public function index()
    {
        $sessions = MovieSession::with('movies', 'cinemaHall')->get();
        return view('admin.sessions.index', compact('sessions'));
    }

    public function create()
    {
        $movies = Movie::all();
        $cinemaHalls = CinemaHall::all();
        return view('admin.sessions.create', compact('movies', 'cinemaHalls'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cinema_hall_id' => 'required|integer|exists:cinema_halls,id',
            'start_time' => 'required|date_format:Y-m-d\TH:i',
            'end_time' => 'required|date_format:Y-m-d\TH:i|after:start_time',
            'movie_ids' => 'required|array',
            'movie_ids.*' => 'exists:movies,id',
        ]);

        $session = MovieSession::create([
            'cinema_hall_id' => $request->cinema_hall_id,
            'start_time' => Carbon::createFromFormat('Y-m-d\TH:i', $request->start_time),
            'end_time' => Carbon::createFromFormat('Y-m-d\TH:i', $request->end_time),
        ]);

        // Привязка фильмов к сеансу
        $session->movies()->sync($request->movie_ids);

        return redirect()->route('admin.sessions.index')->with('status', 'Сеанс успешно добавлен.');
    }

    public function edit(MovieSession $session)
    {
        $movies = Movie::all();
        $cinemaHalls = CinemaHall::all();
        return view('admin.sessions.edit', compact('session', 'movies', 'cinemaHalls'));
    }

    public function update(Request $request, MovieSession $session)
    {
        $request->validate([
            'cinema_hall_id' => 'required|integer|exists:cinema_halls,id',
            'start_time' => 'required|date_format:Y-m-d\TH:i',
            'end_time' => 'required|date_format:Y-m-d\TH:i|after:start_time',
            'movie_ids' => 'required|array',
            'movie_ids.*' => 'exists:movies,id',
        ]);

        $session->update([
            'cinema_hall_id' => $request->cinema_hall_id,
            'start_time' => Carbon::createFromFormat('Y-m-d\TH:i', $request->start_time),
            'end_time' => Carbon::createFromFormat('Y-m-d\TH:i', $request->end_time),
        ]);

        // Обновление привязки фильмов к сеансу
        $session->movies()->sync($request->movie_ids);

        return redirect()->route('admin.sessions.index')->with('status', 'Сеанс успешно обновлен.');
    }

    public function destroy(MovieSession $session)
    {
        $session->movies()->detach(); // Отвязываем фильмы при удалении
        $session->delete();

        return redirect()->route('admin.sessions.index')->with('status', 'Сеанс успешно удален.');
    }
}
