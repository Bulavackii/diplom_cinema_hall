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
    public function seance()
    {
        return $this->belongsTo(Seance::class);
    }

    /**
     * Билет принадлежит месту.
     */
    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }
}
