<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Theatre extends Model
{
    use HasFactory;

    protected $fillable = [
        'theatre_name', 
        'date',
        'time_start',
        'time_end',
        'movie_id'
    ];
    public function movie(): BelongsTo
    {
        return $this->belongsTo('App\Models\Movie','id','movie_id');
    }
}
