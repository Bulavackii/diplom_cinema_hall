<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'country',
        'genre',
        'duration',
        'poster_url',
    ];

    // Связь многие ко многим с сеансами через таблицу movie_session_movie
    public function sessions()
    {
        return $this->belongsToMany(MovieSession::class, 'movie_session_movie', 'movie_id', 'session_id');
    }
}

