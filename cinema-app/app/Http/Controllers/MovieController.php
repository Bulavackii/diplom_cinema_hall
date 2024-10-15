<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        return view('admin.movies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'country' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'poster' => 'nullable|image|max:2048', // Валидируем файл
        ]);

        $movie = new Movie($validated);

        if ($request->hasFile('poster')) {
            // Загрузка постера
            $posterPath = $request->file('poster')->move(public_path('client/i'), $request->file('poster')->getClientOriginalName());
            $movie->poster_url = 'client/i/' . $request->file('poster')->getClientOriginalName();
        }

        $movie->save();

        return redirect()->route('admin.movies.index')->with('success', 'Фильм успешно добавлен.');
    }

    public function edit(Movie $movie)
    {
        return view('admin.movies.edit', compact('movie'));
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'country' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'poster' => 'nullable|image|max:2048', // Валидируем файл
        ]);

        $movie->update($validated);

        if ($request->hasFile('poster')) {
            // Удаляем старый постер если нужно
            if ($request->has('delete_poster') && $movie->poster_url) {
                unlink(public_path($movie->poster_url));
                $movie->poster_url = null;
            }

            // Загружаем новый постер
            $posterPath = $request->file('poster')->move(public_path('client/i'), $request->file('poster')->getClientOriginalName());
            $movie->poster_url = 'client/i/' . $request->file('poster')->getClientOriginalName();
        }

        $movie->save();

        return redirect()->route('admin.movies.index')->with('success', 'Фильм успешно обновлен.');
    }

    public function destroy(Movie $movie)
    {
        if ($movie->poster_url) {
            unlink(public_path($movie->poster_url));
        }

        $movie->delete();

        return redirect()->route('admin.movies.index')->with('success', 'Фильм успешно удален.');
    }
}
