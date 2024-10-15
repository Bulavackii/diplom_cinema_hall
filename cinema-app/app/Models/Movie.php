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

    /**
     * Связь с сеансами.
     */
    public function movieSessions()
    {
        return $this->hasMany(MovieSession::class);
    }
    public function seances()
{
    return $this->hasMany(Seance::class);
}

}
