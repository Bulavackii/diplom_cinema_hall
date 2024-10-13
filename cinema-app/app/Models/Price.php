<!-- Price.php -->
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_session_id',
        'cinema_hall_id',
        'seat_type',
        'price',
    ];

    public function movieSession()
    {
        return $this->belongsTo(MovieSession::class);
    }

    public function cinemaHall()
    {
        return $this->belongsTo(CinemaHall::class);
    }
}
