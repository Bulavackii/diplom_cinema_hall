<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CinemaHall extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rows',
        'seats_per_row',
    ];

    public function sessions()
    {
        return $this->hasMany(MovieSession::class);
    }

    // Метод для активации зала
    public function activate()
    {
        $this->active = true;
        $this->save();
    }

    // Метод для деактивации зала
    public function deactivate()
    {
        $this->active = false;
        $this->save();
    }

    // Метод для проверки, активен ли зал
    public function isActive()
    {
        return $this->active;
    }
}
