<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'title',
        'video',
        'price',
        'available_cps',
        'product'
    ];

    public function getFilmsCart(){
        return $this->hasMany('App\Model\Cart','film_id','id');
    }

    public function getGenre(){
        return $this->hasMany('App\Model\Genre', 'film_id','id');
    }
}
