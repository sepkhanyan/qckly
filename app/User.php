<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'country_code', 'mobile_number', 'api_token', 'otp', 'lang'
    ];
    protected  $table = 'users';

    protected $primaryKey = 'id';
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['created_at', 'updated_at', 'expired_at'];

    public function address()
    {
      return  $this->hasMany('App\Address', 'user_id');
    }

    public function order()
    {
        return  $this->hasMany('App\Order', 'user_id');
    }
}
