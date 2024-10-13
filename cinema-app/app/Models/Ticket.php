<!-- Ticket.php -->

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['session_id', 'seat_id', 'qr_code'];

    /**
     * Билет принадлежит сеансу.
     */
    public function session()
    {
        return $this->belongsTo(MovieSession::class);
    }

    /**
     * Билет связан с местом.
     */
    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }
}
