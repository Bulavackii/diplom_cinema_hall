<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'cinema_hall_id',
        'start_time',
        'end_time',
        'movie_id', // Добавлено для связи с фильмом
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // Связь с одним фильмом (каждый сеанс связан с одним фильмом)
    public function movies()
{
    return $this->belongsToMany(Movie::class, 'movie_session_movie', 'session_id', 'movie_id');
}



    // Связь с залом
    public function cinemaHall()
    {
        return $this->belongsTo(CinemaHall::class);
    }

    // Форматирование времени начала
    public function getFormattedStartTimeAttribute()
    {
        return $this->start_time ? $this->start_time->format('d.m.Y H:i') : null;
    }

    // Форматирование времени окончания
    public function getFormattedEndTimeAttribute()
    {
        return $this->end_time ? $this->end_time->format('d.m.Y H:i') : null;
    }

    // Проверка, доступен ли сеанс для бронирования (время окончания больше текущего времени)
    public function isAvailable()
    {
        return $this->end_time > now();
    }
}
