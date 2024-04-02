<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Desarrolladora extends Model
{
    use HasFactory;

    public function videojuegos(): HasMany
    {
   	 return $this->hasMany(Videojuego::class);
    }

    public function distribuidora(): BelongsTo
    {
   	 return $this->belongsTo(Distribuidora::class);
    }
}
