<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    public $timestamps =true;

    protected $fillable = [
        'firstname',
        'middle_name',
        'surname',
        'gender',
        'email',
        'dob',
        'phone',
        'password'
    ];

    protected $hidden = [
        'password', 'deleted_at'
    ];

    public function getPasswordResetEmail(){
        return $this->email;
    }

    public function customerOrders(){
        return $this->hasMany('App\Model\Orders','customer_id','id');
    }

    public function getCustomerCarts(){
        return $this->hasMany('App\Model\Cart','customer_id','id');
    }
}
