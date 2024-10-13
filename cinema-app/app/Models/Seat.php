<!-- Seat.php -->
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = ['cinema_hall_id', 'row', 'seat_number', 'type'];

    /**
     * Место принадлежит кинозалу.
     */
    public function cinemaHall()
    {
        return $this->belongsTo(CinemaHall::class);
    }

    /**
     * Место может быть связано с билетом.
     */
    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }
}
