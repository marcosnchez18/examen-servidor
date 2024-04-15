<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Videojuego extends Model
{
    use HasFactory;

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'posesiones');
    }

    public function desarrolladora(): BelongsTo
    {
        return $this->belongsTo(Desarrolladora::class);
    }

    public function es_par_impar()
    {
        return $this->id % 2 == 0 ? 'par' : 'impar';
    }
}

// $videojuego = Videojuego::find($id);
