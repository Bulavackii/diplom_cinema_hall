<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = ['cinema_hall_id', 'movie_id', 'start_time', 'end_time'];

    /**
     * Сеанс относится к фильму.
     */
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * Сеанс относится к кинозалу.
     */
    public function cinemaHall()
    {
        return $this->belongsTo(CinemaHall::class);
    }

    /**
     * Сеанс имеет много билетов.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
