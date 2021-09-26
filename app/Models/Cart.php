<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory, SoftDeletes;
    public $timestamps = true;

    protected $fillable = [
        'customer_id',
        'film_id',
        'shopping_id'
    ];

    /**
     * Get the customer having the cart
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(){
        return $this->belongsTo('App\Models\Customer','customer_id','id');
    }

    public function film(){
        return $this->belongsTo('App\Models\Film','film_id','id');
    }
}
