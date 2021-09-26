<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'customer_id',
        'shopping_id',
        'payment_status',
        'number_items',
        'amount'
    ];

    /**
     * Get the customer who owns the order
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(){
        return $this->belongsTo('App\Models\Customer','customer_id','id');
    }

    public function cart(){
        return $this->belongsTo('App\Models\Cart','cart_id','id');
    }
}
