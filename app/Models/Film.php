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
        'location',
        'price',
        'available_cps',
        'product'
    ];

    /**
     * Get the cart containing  the film
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cart(){
        return $this->hasMany('App\Models\Cart','film_id','id');
    }

    /**
     * Get the order of the film
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order(){
        return $this->hasMany('App\Models\Order','film_id','id');
    }

    /**
     * Get the genre(s) of the file
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function genre(){
        return $this->hasMany('App\Models\Genre', 'film_id','id');
    }
}
