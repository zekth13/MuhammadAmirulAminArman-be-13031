<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'release',
        'length',
        'description',
        'mpaa_rating',
        'genre_1',
        'genre_2',
        'genre_3',
        'director',
        'actor_1',
        'actor_2',
        'actor_3',
        'language'
    ];
    // public function theatre(): HasMany
    // {
    //     return $this->hasMany(Theatre::class);
    // }
    // public function ratings(): HasMany
    // {
    //     return $this->hasMany(Rating::class);
    // }
}
