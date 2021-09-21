<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Customer extends Authenticatable implements JWTSubject
{
    use HasFactory, SoftDeletes, Notifiable;
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

    /**
     * Get the email the email to send the password reset link to
     * @return mixed
     */
    public function getPasswordResetEmail(){
        return $this->email;
    }

    /**
     * Get the orders of a customer by relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customerOrders(){
        return $this->hasMany('App\Model\Orders','customer_id','id');
    }

    /**
     * Get the cart associated to a customer by relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getCustomerCarts(){
        return $this->hasMany('App\Model\Cart','customer_id','id');
    }

    /**
     * Get the JWT authentication identifier
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
