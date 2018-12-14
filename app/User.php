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
    protected $table = 'users';


    protected $fillable = [
        'username',
        'email',
        'password',
        'country_code',
        'mobile_number',
        'api_token',
        'otp',
        'admin',
        'first_name',
        'last_name',
        'group_id',
        'image',
        'lang'
    ];

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
        return $this->hasMany('App\Address', 'user_id');
    }

    public function order()
    {
        return $this->hasMany('App\Order', 'user_id');
    }

    public function cart()
    {
        return $this->hasMany('App\UserCart', 'user_id');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant', 'restaurant_id');
    }

    public function image()
    {
        return $this->hasMany('App\ImageTool', 'user_id');
    }


    public function scopeName($query, $val)
    {
        if (!empty($val)) {
            return $query->where('username', 'like', '%' . $val . '%')
                ->orWhere('email', 'like', '%' . $val . '%');
        }

        return $query;
    }

    public static function getUserByToken($req_auth){
       $acual_token = str_replace("Bearer ","" ,$req_auth);
       $ud = \DB::table('users')->where('api_token', '=',$acual_token)->first();

       if($ud){
           return $ud->id;
       }
       return false;
    }
}
