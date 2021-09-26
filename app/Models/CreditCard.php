<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable =[
        'customer_id',
        'bank_name',
        'card_type',
        'card_number',
        'cvv',
        'expiry_date'
    ];

    /**
     * Hidden attributes
     * @var string[]
     */
//    protected $hidden=[
//        'card_number', 'cvv'
//    ];

    public function customer(){
        return $this->belongsTo('App\Models\Customer','customer_id','id');;
    }
}
