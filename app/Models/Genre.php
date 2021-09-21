<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable = [
        'film_id',
        'genre'
    ];

    public function getFilm(){
        return $this->belongsTo(Film::class,'film_id','id');
    }
}
